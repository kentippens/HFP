<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

abstract class BaseImportService
{
    protected int $batchSize = 100;
    protected int $maxMemoryUsage = 80; // Percentage
    protected int $maxFileSize = 10485760; // 10MB in bytes
    protected array $validationRules = [];
    protected array $importLog = [];
    protected int $successfulRows = 0;
    protected int $failedRows = 0;
    protected array $errorSummary = [];

    abstract protected function getModel(): string;
    abstract public function getValidationRules(): array;
    abstract protected function transformRow(array $row): array;
    abstract protected function createRecord(array $data): void;

    /**
     * Validate uploaded CSV file
     */
    public function validateFile(UploadedFile $file): array
    {
        $errors = [];

        // Check file size
        if ($file->getSize() > $this->maxFileSize) {
            $errors[] = 'File size exceeds maximum allowed size of ' . number_format($this->maxFileSize / 1048576, 1) . 'MB';
        }

        // Check file extension
        if (!in_array(strtolower($file->getClientOriginalExtension()), ['csv', 'txt'])) {
            $errors[] = 'File must be a CSV file';
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), ['text/csv', 'text/plain', 'application/csv'])) {
            $errors[] = 'Invalid file type. Please upload a valid CSV file';
        }

        // Try to read first few lines to validate CSV structure
        if (empty($errors)) {
            try {
                $handle = fopen($file->getRealPath(), 'r');
                $header = fgetcsv($handle);

                if ($header === false || empty($header)) {
                    $errors[] = 'CSV file appears to be empty or invalid';
                } elseif (count($header) < 2) {
                    $errors[] = 'CSV file must have at least 2 columns';
                }

                fclose($handle);
            } catch (\Exception $e) {
                $errors[] = 'Unable to read CSV file: ' . $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Preview CSV data for validation
     */
    public function previewData(UploadedFile $file, int $limit = 10): array
    {
        $preview = [
            'headers' => [],
            'sample_data' => [],
            'total_rows' => 0,
            'validation_errors' => [],
            'field_mapping' => []
        ];

        try {
            $handle = fopen($file->getRealPath(), 'r');

            // Get headers
            $headers = fgetcsv($handle);
            $preview['headers'] = $headers;

            // Suggest field mappings
            $preview['field_mapping'] = $this->suggestFieldMapping($headers);

            // Count total rows and get sample data
            $rowCount = 0;
            $sampleData = [];

            while (($row = fgetcsv($handle)) !== false && count($sampleData) < $limit) {
                $rowCount++;

                if (count($sampleData) < $limit) {
                    $rowData = array_combine($headers, array_pad($row, count($headers), ''));
                    $sampleData[] = $rowData;

                    // Validate sample row
                    $validator = Validator::make($rowData, $this->getValidationRules());
                    if ($validator->fails()) {
                        $preview['validation_errors']["Row {$rowCount}"] = $validator->errors()->toArray();
                    }
                }
            }

            // Continue counting remaining rows
            while (fgetcsv($handle) !== false) {
                $rowCount++;
            }

            $preview['total_rows'] = $rowCount;
            $preview['sample_data'] = $sampleData;

            fclose($handle);

        } catch (\Exception $e) {
            $preview['validation_errors']['File Error'] = ['Unable to process file: ' . $e->getMessage()];
        }

        return $preview;
    }

    /**
     * Suggest field mapping based on header names
     */
    protected function suggestFieldMapping(array $headers): array
    {
        $mapping = [];
        $modelFields = array_keys($this->getValidationRules());

        foreach ($headers as $index => $header) {
            $normalized = strtolower(str_replace([' ', '_', '-'], '', $header));

            // Look for exact matches first
            foreach ($modelFields as $field) {
                $normalizedField = strtolower(str_replace([' ', '_', '-'], '', $field));
                if ($normalized === $normalizedField) {
                    $mapping[$index] = $field;
                    break;
                }
            }

            // Look for partial matches if no exact match found
            if (!isset($mapping[$index])) {
                foreach ($modelFields as $field) {
                    $normalizedField = strtolower(str_replace([' ', '_', '-'], '', $field));
                    if (Str::contains($normalized, $normalizedField) || Str::contains($normalizedField, $normalized)) {
                        $mapping[$index] = $field;
                        break;
                    }
                }
            }
        }

        return $mapping;
    }

    /**
     * Process the import with user-defined field mapping
     */
    public function import(UploadedFile $file, array $fieldMapping = [], bool $skipErrors = true): array
    {
        $this->resetCounters();

        try {
            DB::beginTransaction();

            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle); // Skip header row

            $batch = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                try {
                    // Map CSV columns to model fields
                    $mappedData = $this->mapRowData($row, $headers, $fieldMapping);

                    // Transform data
                    $transformedData = $this->transformRow($mappedData);

                    // Validate data
                    $validator = Validator::make($transformedData, $this->getValidationRules());

                    if ($validator->fails()) {
                        $this->logError($rowNumber, 'Validation failed', $validator->errors()->toArray());

                        if (!$skipErrors) {
                            throw new \ValidationException($validator);
                        }

                        continue;
                    }

                    $batch[] = $transformedData;

                    // Process batch when it reaches the batch size
                    if (count($batch) >= $this->batchSize) {
                        $this->processBatch($batch);
                        $batch = [];

                        // Check memory usage
                        if ($this->isMemoryUsageHigh()) {
                            throw new \RuntimeException('Memory usage too high, aborting import');
                        }
                    }

                } catch (\Exception $e) {
                    $this->logError($rowNumber, 'Processing error', [$e->getMessage()]);

                    if (!$skipErrors) {
                        throw $e;
                    }
                }
            }

            // Process remaining batch
            if (!empty($batch)) {
                $this->processBatch($batch);
            }

            fclose($handle);

            // Log the import activity
            ActivityLogger::logCustom('data_import', null, [
                'model' => class_basename($this->getModel()),
                'file_name' => $file->getClientOriginalName(),
                'successful_rows' => $this->successfulRows,
                'failed_rows' => $this->failedRows,
                'total_rows' => $rowNumber - 1
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->getImportSummary();
    }

    /**
     * Map CSV row data to model fields
     */
    protected function mapRowData(array $row, array $headers, array $fieldMapping): array
    {
        $mappedData = [];

        foreach ($fieldMapping as $columnIndex => $fieldName) {
            if (isset($row[$columnIndex])) {
                $mappedData[$fieldName] = trim($row[$columnIndex]);
            }
        }

        return $mappedData;
    }

    /**
     * Process a batch of records
     */
    protected function processBatch(array $batch): void
    {
        foreach ($batch as $data) {
            try {
                $this->createRecord($data);
                $this->successfulRows++;
            } catch (\Exception $e) {
                $this->logError(0, 'Database error', [$e->getMessage()]);
                $this->failedRows++;
            }
        }
    }

    /**
     * Log import error
     */
    protected function logError(int $rowNumber, string $type, array $details): void
    {
        $error = [
            'row' => $rowNumber,
            'type' => $type,
            'details' => $details,
            'timestamp' => now()
        ];

        $this->importLog[] = $error;
        $this->failedRows++;

        // Group errors by type for summary
        if (!isset($this->errorSummary[$type])) {
            $this->errorSummary[$type] = 0;
        }
        $this->errorSummary[$type]++;

        Log::warning('Import error', $error);
    }

    /**
     * Check if memory usage is too high
     */
    protected function isMemoryUsageHigh(): bool
    {
        $used = memory_get_usage(true);
        $limit = ini_get('memory_limit');

        if ($limit == -1) {
            return false; // No memory limit
        }

        $limitBytes = $this->convertToBytes($limit);
        $usagePercent = ($used / $limitBytes) * 100;

        return $usagePercent > $this->maxMemoryUsage;
    }

    /**
     * Convert memory limit string to bytes
     */
    protected function convertToBytes(string $value): int
    {
        $unit = strtolower(substr($value, -1));
        $value = (int) substr($value, 0, -1);

        switch ($unit) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    /**
     * Reset counters for new import
     */
    protected function resetCounters(): void
    {
        $this->successfulRows = 0;
        $this->failedRows = 0;
        $this->importLog = [];
        $this->errorSummary = [];
    }

    /**
     * Get import summary
     */
    public function getImportSummary(): array
    {
        return [
            'successful_rows' => $this->successfulRows,
            'failed_rows' => $this->failedRows,
            'total_rows' => $this->successfulRows + $this->failedRows,
            'error_summary' => $this->errorSummary,
            'import_log' => $this->importLog,
            'success_rate' => $this->successfulRows + $this->failedRows > 0
                ? round(($this->successfulRows / ($this->successfulRows + $this->failedRows)) * 100, 2)
                : 0
        ];
    }

    /**
     * Generate sample CSV template
     */
    public function generateTemplate(): string
    {
        $headers = array_keys($this->getValidationRules());
        $sampleData = $this->getSampleData();

        $output = fopen('php://temp', 'w');

        // Write headers
        fputcsv($output, $headers);

        // Write sample rows
        foreach ($sampleData as $row) {
            $orderedRow = [];
            foreach ($headers as $header) {
                $orderedRow[] = $row[$header] ?? '';
            }
            fputcsv($output, $orderedRow);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }

    /**
     * Get sample data for template generation
     */
    protected function getSampleData(): array
    {
        // Override in child classes to provide meaningful sample data
        return [];
    }
}