<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CKEditorController extends Controller
{
    /**
     * Maximum file size in KB (5MB)
     */
    private const MAX_FILE_SIZE = 5120;

    /**
     * Allowed file types for upload
     */
    private const ALLOWED_TYPES = ['jpeg', 'png', 'jpg', 'gif', 'webp'];

    /**
     * Upload directory for CKEditor images
     */
    private const UPLOAD_DIRECTORY = 'blog-content';

    /**
     * Handle CKEditor image uploads with comprehensive error handling
     */
    public function upload(Request $request)
    {
        // Log the upload attempt
        Log::info('CKEditor upload attempt', [
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            // Validate the upload request with detailed error messages
            $this->validateUpload($request);

            $file = $request->file('upload');
            
            // Additional security checks
            $this->performSecurityChecks($file);
            
            // Generate a secure filename
            $filename = $this->generateSecureFilename($file);
            
            // Ensure upload directory exists and is writable
            $this->ensureUploadDirectoryExists();
            
            // Store the file with error handling
            $path = $this->storeFile($file, $filename);
            
            // Get the full URL to the uploaded file
            $url = Storage::disk('public')->url($path);
            
            // Verify the file was actually uploaded and is accessible
            $this->verifyUploadedFile($path);
            
            // Log successful upload
            Log::info('CKEditor upload successful', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'path' => $path
            ]);
            
            // Return the response in CKEditor's expected format
            return response()->json([
                'url' => $url,
                'uploaded' => true,
                'fileName' => $file->getClientOriginalName(),
            ]);
            
        } catch (ValidationException $e) {
            return $this->handleValidationError($e);
        } catch (FileException $e) {
            return $this->handleFileError($e);
        } catch (\Exception $e) {
            return $this->handleGeneralError($e, $request);
        }
    }

    /**
     * Validate the upload request with detailed error messages
     */
    private function validateUpload(Request $request): void
    {
        $rules = [
            'upload' => [
                'required',
                'file',
                'image',
                'mimes:' . implode(',', self::ALLOWED_TYPES),
                'max:' . self::MAX_FILE_SIZE,
                'dimensions:min_width=10,min_height=10,max_width=4000,max_height=4000'
            ]
        ];

        $messages = [
            'upload.required' => 'No file was provided for upload.',
            'upload.file' => 'The uploaded item is not a valid file.',
            'upload.image' => 'The uploaded file must be an image.',
            'upload.mimes' => 'The image must be a file of type: ' . implode(', ', self::ALLOWED_TYPES) . '.',
            'upload.max' => 'The image size cannot exceed ' . (self::MAX_FILE_SIZE / 1024) . 'MB.',
            'upload.dimensions' => 'The image dimensions must be between 10x10 and 4000x4000 pixels.'
        ];

        $request->validate($rules, $messages);
    }

    /**
     * Perform additional security checks on the uploaded file
     */
    private function performSecurityChecks($file): void
    {
        // Check file size
        if ($file->getSize() > (self::MAX_FILE_SIZE * 1024)) {
            throw new \Exception('File size exceeds maximum allowed size.');
        }

        // Check MIME type against file extension
        $mimeType = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        
        $allowedMimes = [
            'jpeg' => ['image/jpeg', 'image/jpg'],
            'jpg' => ['image/jpeg', 'image/jpg'],
            'png' => ['image/png'],
            'gif' => ['image/gif'],
            'webp' => ['image/webp']
        ];

        if (!isset($allowedMimes[$extension]) || !in_array($mimeType, $allowedMimes[$extension])) {
            throw new \Exception('File type mismatch detected. Security check failed.');
        }

        // Check for executable content in file
        $fileContent = file_get_contents($file->getRealPath());
        if (preg_match('/<\?php|<script|javascript:|data:/i', $fileContent)) {
            throw new \Exception('Potentially malicious content detected in file.');
        }
    }

    /**
     * Generate a secure filename
     */
    private function generateSecureFilename($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $timestamp = time();
        $random = Str::random(12);
        
        // Sanitize original filename for reference
        $originalName = preg_replace('/[^a-zA-Z0-9._-]/', '', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $originalName = substr($originalName, 0, 20); // Limit length
        
        return $timestamp . '_' . $random . '_' . $originalName . '.' . $extension;
    }

    /**
     * Ensure the upload directory exists and is writable
     */
    private function ensureUploadDirectoryExists(): void
    {
        $fullPath = storage_path('app/public/' . self::UPLOAD_DIRECTORY);
        
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true)) {
                throw new \Exception('Failed to create upload directory.');
            }
        }

        if (!is_writable($fullPath)) {
            throw new \Exception('Upload directory is not writable.');
        }
    }

    /**
     * Store the file with error handling
     */
    private function storeFile($file, string $filename): string
    {
        try {
            $path = $file->storeAs(self::UPLOAD_DIRECTORY, $filename, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file.');
            }
            
            return $path;
        } catch (\Exception $e) {
            throw new FileException('File storage failed: ' . $e->getMessage());
        }
    }

    /**
     * Verify the uploaded file exists and is accessible
     */
    private function verifyUploadedFile(string $path): void
    {
        if (!Storage::disk('public')->exists($path)) {
            throw new \Exception('File was not properly stored.');
        }

        $fullPath = Storage::disk('public')->path($path);
        if (!is_readable($fullPath)) {
            throw new \Exception('Uploaded file is not readable.');
        }
    }

    /**
     * Handle validation errors
     */
    private function handleValidationError(ValidationException $e)
    {
        Log::warning('CKEditor upload validation failed', [
            'user_id' => auth()->id(),
            'errors' => $e->errors()
        ]);

        $firstError = collect($e->errors())->flatten()->first();
        
        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => $firstError ?: 'Validation failed.'
            ]
        ], 422);
    }

    /**
     * Handle file-specific errors
     */
    private function handleFileError(FileException $e)
    {
        Log::error('CKEditor file error', [
            'user_id' => auth()->id(),
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'File upload failed: ' . $e->getMessage()
            ]
        ], 500);
    }

    /**
     * Handle general errors
     */
    private function handleGeneralError(\Exception $e, Request $request)
    {
        Log::error('CKEditor upload error', [
            'user_id' => auth()->id(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->except(['upload']) // Exclude file data
        ]);

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Upload failed due to an unexpected error. Please try again or contact support.'
            ]
        ], 500);
    }
}