<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PDOException;

class DatabaseExceptionHandler
{
    /**
     * Handle database exceptions and return user-friendly messages
     *
     * @param \Exception $exception
     * @return array
     */
    public static function handle(\Exception $exception): array
    {
        $error = [
            'user_message' => 'We\'re experiencing technical difficulties. Please try again later.',
            'technical_message' => $exception->getMessage(),
            'code' => 500,
            'retry' => true,
        ];

        // Handle specific database errors
        if ($exception instanceof QueryException || $exception instanceof PDOException) {
            $errorCode = $exception->getCode();
            
            switch ($errorCode) {
                case 1049: // Unknown database
                    $error['user_message'] = 'Database configuration error. Please contact support.';
                    $error['retry'] = false;
                    break;
                    
                case 1045: // Access denied
                    $error['user_message'] = 'Database access error. Please contact support.';
                    $error['retry'] = false;
                    break;
                    
                case 2002: // Connection refused
                case 'HY000': // General connection error
                    $error['user_message'] = 'Unable to connect to our servers. Please try again in a few minutes.';
                    $error['code'] = 503;
                    break;
                    
                case 1062: // Duplicate entry
                    $error['user_message'] = 'This information already exists. Please check your input.';
                    $error['code'] = 409;
                    $error['retry'] = false;
                    break;
                    
                case 1451: // Foreign key constraint
                    $error['user_message'] = 'This item cannot be modified as it\'s being used elsewhere.';
                    $error['code'] = 409;
                    $error['retry'] = false;
                    break;
                    
                case 1264: // Out of range value
                case 1406: // Data too long
                    $error['user_message'] = 'The information provided is invalid. Please check and try again.';
                    $error['code'] = 422;
                    $error['retry'] = false;
                    break;
                    
                case 42: // Syntax error or access violation
                case '42S02': // Base table or view not found
                    $error['user_message'] = 'System configuration error. Please contact support.';
                    Log::critical('Database structure error', [
                        'error' => $exception->getMessage(),
                        'trace' => $exception->getTraceAsString()
                    ]);
                    break;
                    
                case 1205: // Lock wait timeout
                case 1213: // Deadlock
                    $error['user_message'] = 'The system is busy. Please try again.';
                    $error['code'] = 503;
                    break;
                    
                default:
                    // Log unhandled database errors for investigation
                    Log::error('Unhandled database error', [
                        'code' => $errorCode,
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTraceAsString()
                    ]);
            }
        }
        
        return $error;
    }
    
    /**
     * Check if the exception is a connection error
     *
     * @param \Exception $exception
     * @return bool
     */
    public static function isConnectionError(\Exception $exception): bool
    {
        if (!($exception instanceof QueryException || $exception instanceof PDOException)) {
            return false;
        }
        
        $connectionErrorCodes = [2002, 2003, 2004, 2005, 2006, 1045, 1049, 'HY000'];
        return in_array($exception->getCode(), $connectionErrorCodes);
    }
    
    /**
     * Check if the error is retryable
     *
     * @param \Exception $exception
     * @return bool
     */
    public static function isRetryable(\Exception $exception): bool
    {
        if (!($exception instanceof QueryException || $exception instanceof PDOException)) {
            return false;
        }
        
        $retryableCodes = [1205, 1213, 2002, 2003, 2006, 'HY000'];
        return in_array($exception->getCode(), $retryableCodes);
    }
}