<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TrackingScriptErrorController extends Controller
{
    /**
     * Report tracking script errors from the client
     */
    public function report(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'errors' => 'required|array',
                'errors.*.scriptId' => 'required_with:errors.*|string',
                'errors.*.scriptName' => 'required_with:errors.*|string',
                'errors.*.error' => 'required_with:errors.*|string',
                'errors.*.timestamp' => 'required_with:errors.*|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid error data format',
                    'errors' => $validator->errors()
                ], 400);
            }

            $errors = $request->input('errors', []);
            
            foreach ($errors as $error) {
                Log::error('Client-side tracking script error', [
                    'script_id' => $error['scriptId'],
                    'script_name' => $error['scriptName'],
                    'error_message' => $error['error'],
                    'timestamp' => $error['timestamp'],
                    'user_agent' => $request->header('User-Agent'),
                    'ip_address' => $request->ip(),
                    'url' => $request->header('Referer'),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Errors reported successfully',
                'count' => count($errors)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to process tracking script error report', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process error report'
            ], 500);
        }
    }
}