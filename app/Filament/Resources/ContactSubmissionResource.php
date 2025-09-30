<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-envelope';
    }

    public static function getNavigationLabel(): string
    {
        return 'Contact Submissions';
    }

    public static function getModelLabel(): string
    {
        return 'Contact Submission';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Contact Submissions';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationBadge(): ?string
    {
        $unreadCount = static::getModel()::where('is_read', false)->count();

        return $unreadCount > 0 ? (string) $unreadCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_read', false)->count() > 0 ? 'warning' : null;
    }

    protected static array $sourceLabels = [
        'homepage_form' => 'Homepage Hero',
        'contact_page' => 'Contact Page',
        'newsletter' => 'Newsletter Subscription',
        'about_page' => 'About Page',
        'service_form' => 'Service Page',
    ];

    public static function getSourceLabel(string $source): string
    {
        // Handle service-specific sources (e.g., service_carpet-cleaning)
        if (str_starts_with($source, 'service_')) {
            $serviceName = str_replace('service_', '', $source);
            $serviceName = str_replace('-', ' ', $serviceName);
            $serviceName = str_replace('_', ' ', $serviceName);

            return 'Service: '.ucwords($serviceName);
        }

        return self::$sourceLabels[$source] ?? ucwords(str_replace('_', ' ', $source));
    }

    public static function getSourceOptions(): array
    {
        $options = [];

        // Add predefined sources
        foreach (self::$sourceLabels as $value => $label) {
            $options[$value] = $label;
        }

        // Add dynamic service sources from existing submissions
        $serviceSources = ContactSubmission::where('source', 'like', 'service_%')
            ->distinct()
            ->pluck('source');

        foreach ($serviceSources as $source) {
            $options[$source] = self::getSourceLabel($source);
        }

        return $options;
    }

    /**
     * Get active filter information for filename
     */
    protected static function getActiveFilterInfo(Tables\Table $table): ?string
    {
        $filters = [];
        $tableFilters = $table->getFilters();
        
        foreach ($tableFilters as $name => $filter) {
            $state = $table->getFilterState($name);
            
            if ($state) {
                switch ($name) {
                    case 'today':
                        if ($state) {
                            $filters[] = 'today';
                        }
                        break;
                    case 'source':
                        if (isset($state['value']) && $state['value']) {
                            $filters[] = 'source-' . str_replace(' ', '-', strtolower(self::getSourceLabel($state['value'])));
                        }
                        break;
                    case 'service_requested':
                        if (isset($state['value']) && $state['value']) {
                            $filters[] = 'service-' . $state['value'];
                        }
                        break;
                    case 'is_read':
                        if (isset($state['value']) && $state['value'] !== '') {
                            $filters[] = $state['value'] ? 'read' : 'unread';
                        }
                        break;
                }
            }
        }
        
        return $filters ? implode('-', $filters) : null;
    }

    /**
     * Get active filters as human-readable text
     */
    protected static function getActiveFiltersText(Tables\Table $table): ?string
    {
        $filters = [];
        $tableFilters = $table->getFilters();
        
        foreach ($tableFilters as $name => $filter) {
            $state = $table->getFilterState($name);
            
            if ($state) {
                switch ($name) {
                    case 'today':
                        if ($state) {
                            $filters[] = 'Today Only';
                        }
                        break;
                    case 'source':
                        if (isset($state['value']) && $state['value']) {
                            $filters[] = 'Source: ' . self::getSourceLabel($state['value']);
                        }
                        break;
                    case 'service_requested':
                        if (isset($state['value']) && $state['value']) {
                            $serviceOptions = [
                                'request-callback' => 'Request A Callback',
                                'carpet-cleaning' => 'Carpet Cleaning',
                                'commercial-cleaning' => 'Commercial Cleaning',
                                'house-cleaning' => 'House Cleaning',
                            ];
                            $serviceName = $serviceOptions[$state['value']] ?? ucwords(str_replace(['-', '_'], ' ', $state['value']));
                            $filters[] = 'Service: ' . $serviceName;
                        }
                        break;
                    case 'is_read':
                        if (isset($state['value']) && $state['value'] !== '') {
                            $filters[] = 'Status: ' . ($state['value'] ? 'Read' : 'Unread');
                        }
                        break;
                }
            }
        }
        
        return $filters ? implode(', ', $filters) : null;
    }

    /**
     * Validate export preconditions
     */
    public static function validateExportPreconditions(): void
    {
        // Check memory limit
        $memoryLimit = ini_get('memory_limit');
        if ($memoryLimit !== '-1') {
            $memoryBytes = self::convertToBytes($memoryLimit);
            $currentUsage = memory_get_usage(true);
            $availableMemory = $memoryBytes - $currentUsage;
            
            // Require at least 32MB available memory
            if ($availableMemory < 32 * 1024 * 1024) {
                throw new \RuntimeException('Insufficient memory available for export operation');
            }
        }

        // Check if we can create output streams (test php://output availability)
        $testHandle = fopen('php://memory', 'w');
        if (!$testHandle) {
            throw new \RuntimeException('Unable to access output streams for CSV generation');
        }
        fclose($testHandle);

        // Check database connection
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get filtered query safely with error handling
     */
    protected static function getFilteredQuerySafely(Tables\Table $table)
    {
        try {
            return $table->getFilteredTableQuery();
        } catch (\Exception $e) {
            \Log::warning('Failed to get filtered query, falling back to base query', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            // Fallback to basic query if filtered query fails
            return ContactSubmission::query();
        }
    }

    /**
     * Validate record count for export
     */
    public static function validateRecordCount(int $count): void
    {
        // Maximum records to export (configurable)
        $maxRecords = config('app.max_export_records', 50000);
        
        if ($count > $maxRecords) {
            throw new \RuntimeException("Export would contain {$count} records, which exceeds the maximum limit of {$maxRecords}. Please apply more filters to reduce the dataset.");
        }

        if ($count === 0) {
            throw new \RuntimeException('No records found matching the current filters. Please adjust your filters and try again.');
        }
    }

    /**
     * Validate export data
     */
    public static function validateExportData($submissions): void
    {
        if (!$submissions instanceof \Illuminate\Database\Eloquent\Collection) {
            throw new \RuntimeException('Invalid data type for export');
        }

        // Check for essential fields in first record (if any)
        if ($submissions->isNotEmpty()) {
            $firstRecord = $submissions->first();
            $requiredFields = ['id', 'name', 'email', 'created_at'];
            
            foreach ($requiredFields as $field) {
                if (!isset($firstRecord->$field)) {
                    throw new \RuntimeException("Missing required field '{$field}' in export data");
                }
            }
        }
    }

    /**
     * Get active filter information safely
     */
    protected static function getActiveFilterInfoSafely(Tables\Table $table): ?string
    {
        try {
            return self::getActiveFilterInfo($table);
        } catch (\Exception $e) {
            \Log::warning('Failed to get filter info for filename', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Generate safe filename for CSV export
     */
    public static function generateSafeFilename(?string $filterInfo): string
    {
        $timestamp = date('Y-m-d-H-i-s');
        $filename = 'contact-submissions-' . $timestamp;
        
        if ($filterInfo) {
            // Sanitize filter info for filename
            $safeFilterInfo = preg_replace('/[^a-zA-Z0-9\-_]/', '-', $filterInfo);
            $safeFilterInfo = preg_replace('/-+/', '-', $safeFilterInfo);
            $safeFilterInfo = trim($safeFilterInfo, '-');
            
            // Limit total filename length
            if (strlen($safeFilterInfo) > 50) {
                $safeFilterInfo = substr($safeFilterInfo, 0, 50);
            }
            
            $filename .= '-' . $safeFilterInfo;
        }
        
        return $filename . '.csv';
    }

    /**
     * Generate CSV content with comprehensive error handling
     */
    protected static function generateCsvContent($submissions, Tables\Table $table, int $recordCount): void
    {
        $handle = fopen('php://output', 'w');
        
        if (!$handle) {
            throw new \RuntimeException('Failed to open output stream for CSV generation');
        }

        try {
            // Set CSV output settings
            if (function_exists('stream_set_write_buffer')) {
                stream_set_write_buffer($handle, 0);
            }

            // Add CSV headers with filter information and error handling
            try {
                $activeFilters = self::getActiveFiltersText($table);
                if ($activeFilters) {
                    self::writeCsvRowSafely($handle, ['Exported with filters: ' . $activeFilters]);
                    self::writeCsvRowSafely($handle, ['Export date: ' . now()->format('Y-m-d H:i:s')]);
                    self::writeCsvRowSafely($handle, ['Total records: ' . $recordCount]);
                    self::writeCsvRowSafely($handle, []); // Empty row
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to write filter headers to CSV', ['error' => $e->getMessage()]);
            }

            // Add column headers
            self::writeCsvRowSafely($handle, [
                'Date Submitted',
                'Full Name',
                'First Name',
                'Last Name',
                'Email',
                'Phone',
                'Service Requested',
                'Message',
                'Source',
                'Source URI',
                'Read Status',
                'IP Address',
            ]);

            // Add data rows with error handling for each record
            $processedCount = 0;
            foreach ($submissions as $submission) {
                try {
                    $row = self::formatSubmissionRow($submission);
                    self::writeCsvRowSafely($handle, $row);
                    
                    $processedCount++;
                    
                    // Check memory usage periodically
                    if ($processedCount % 1000 === 0) {
                        self::checkMemoryUsage();
                    }
                    
                } catch (\Exception $e) {
                    \Log::error('Failed to process submission row', [
                        'submission_id' => $submission->id ?? 'unknown',
                        'error' => $e->getMessage(),
                        'processed_count' => $processedCount,
                    ]);
                    
                    // Add error row to CSV
                    self::writeCsvRowSafely($handle, [
                        'ERROR',
                        'Failed to process record',
                        '',
                        '',
                        '',
                        '',
                        '',
                        'Error: ' . $e->getMessage(),
                        '',
                        '',
                        '',
                        '',
                    ]);
                }
            }

        } finally {
            if (is_resource($handle)) {
                fclose($handle);
            }
        }
    }

    /**
     * Write CSV row safely with error handling
     */
    protected static function writeCsvRowSafely($handle, array $data): void
    {
        if (!is_resource($handle)) {
            throw new \RuntimeException('Invalid file handle for CSV writing');
        }

        $result = fputcsv($handle, $data);
        if ($result === false) {
            throw new \RuntimeException('Failed to write CSV row');
        }
    }

    /**
     * Format submission row data safely
     */
    public static function formatSubmissionRow($submission): array
    {
        return [
            self::safeFormat($submission->created_at, fn($date) => $date->format('Y-m-d H:i:s')),
            self::safeStringValue($submission->name),
            self::safeStringValue($submission->first_name),
            self::safeStringValue($submission->last_name),
            self::safeStringValue($submission->email),
            self::safeStringValue($submission->phone),
            self::formatServiceRequested($submission->service_requested),
            self::safeStringValue($submission->message, 1000), // Limit message length
            self::safeFormat($submission->source, fn($source) => self::getSourceLabel($source)),
            self::safeStringValue($submission->source_uri, 255),
            $submission->is_read ? 'Read' : 'Unread',
            self::safeStringValue($submission->ip_address),
        ];
    }

    /**
     * Safely format a value with error handling
     */
    public static function safeFormat($value, callable $formatter, string $fallback = '')
    {
        try {
            return $value ? $formatter($value) : $fallback;
        } catch (\Exception $e) {
            \Log::warning('Failed to format value', [
                'value' => $value,
                'error' => $e->getMessage(),
            ]);
            return $fallback;
        }
    }

    /**
     * Safely get string value with length limit
     */
    public static function safeStringValue($value, ?int $maxLength = null): string
    {
        if ($value === null) {
            return '';
        }

        $stringValue = (string) $value;
        
        if ($maxLength && strlen($stringValue) > $maxLength) {
            $stringValue = substr($stringValue, 0, $maxLength - 3) . '...';
        }

        // Remove any control characters that might break CSV
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $stringValue);
    }

    /**
     * Format service requested safely
     */
    public static function formatServiceRequested(?string $service): string
    {
        if (!$service) {
            return 'N/A';
        }

        try {
            return ucwords(str_replace(['-', '_'], ' ', $service));
        } catch (\Exception $e) {
            return $service;
        }
    }

    /**
     * Check memory usage and throw error if too high
     */
    protected static function checkMemoryUsage(): void
    {
        $memoryLimit = ini_get('memory_limit');
        if ($memoryLimit !== '-1') {
            $memoryBytes = self::convertToBytes($memoryLimit);
            $currentUsage = memory_get_usage(true);
            $usagePercent = ($currentUsage / $memoryBytes) * 100;
            
            if ($usagePercent > 90) {
                throw new \RuntimeException('Memory usage too high during export (' . round($usagePercent, 1) . '%)');
            }
        }
    }

    /**
     * Convert memory limit string to bytes
     */
    public static function convertToBytes(string $value): int
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $number = (int) $value;

        switch ($last) {
            case 'g':
                $number *= 1024;
                // fall through
            case 'm':
                $number *= 1024;
                // fall through
            case 'k':
                $number *= 1024;
        }

        return $number;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),

                Schemas\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\TextInput::make('source')
                            ->label('Source')
                            ->formatStateUsing(fn (string $state): string => self::getSourceLabel($state))
                            ->disabled(),
                        Forms\Components\TextInput::make('source_uri')
                            ->label('Source Page URI')
                            ->disabled(),
                        Forms\Components\TextInput::make('service')
                            ->label('Service')
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->columnSpanFull()
                            ->disabled(),
                        Forms\Components\Toggle::make('is_read')
                            ->label('Mark as Read')
                            ->required(),
                    ])->columns(2),

                Schemas\Components\Section::make('Technical Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service')
                    ->label('Service')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => $state ? ucwords(str_replace(['-', '_'], ' ', $state)) : 'N/A'),
                Tables\Columns\TextColumn::make('source')
                    ->formatStateUsing(fn (string $state): string => self::getSourceLabel($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->sortable()
                    ->label('Read'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Submitted At'),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('source_uri')
                    ->label('Source URI')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->label('Today Only')
                    ->query(fn ($query) => $query->whereDate('created_at', today()))
                    ->indicator('Today')
                    ->default(),
                Tables\Filters\SelectFilter::make('source')
                    ->options(fn () => self::getSourceOptions())
                    ->label('Source'),
                Tables\Filters\SelectFilter::make('service_requested')
                    ->options([
                        'request-callback' => 'Request A Callback',
                        'carpet-cleaning' => 'Carpet Cleaning',
                        'commercial-cleaning' => 'Commercial Cleaning',
                        'house-cleaning' => 'House Cleaning',
                    ])
                    ->label('Service'),
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Read Status'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('markAsRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_read' => true]);
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('markAsUnread')
                        ->label('Mark as Unread')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_read' => false]);
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'create' => Pages\CreateContactSubmission::route('/create'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }


    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', ContactSubmission::class) ?? false;
    }

    /**
     * Determine if the user can create records.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', ContactSubmission::class) ?? false;
    }

    /**
     * Determine if the user can edit the record.
     */
    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update', $record) ?? false;
    }

    /**
     * Determine if the user can delete the record.
     */
    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete', $record) ?? false;
    }

    /**
     * Determine if the user can view the record.
     */
    public static function canView($record): bool
    {
        return auth()->user()?->can('view', $record) ?? false;
    }}
