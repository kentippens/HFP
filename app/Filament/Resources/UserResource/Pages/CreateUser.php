<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\PasswordHistory;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User created successfully')
            ->body('The user has been created and can now log in to the system.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            // Ensure required fields are present
            if (empty($data['password'])) {
                throw ValidationException::withMessages([
                    'password' => ['Password is required for new users.']
                ]);
            }
            
            // Set password security fields
            $data['password_changed_at'] = now();
            $data['force_password_change'] = false;
            $data['failed_login_attempts'] = 0;
            
            // Remove confirmation field
            unset($data['password_confirmation']);
            
            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw ValidationException::withMessages([
                    'email' => ['Please provide a valid email address.']
                ]);
            }
            
            return $data;
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Error in mutateFormDataBeforeCreate', [
                'error' => $e->getMessage()
            ]);
            
            Notification::make()
                ->danger()
                ->title('Validation error')
                ->body('There was an error validating your input. Please check the form.')
                ->send();
            
            throw $e;
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();
        
        try {
            // Create the user
            $user = static::getModel()::create($data);
            
            // Record the initial password in history
            if ($user->password) {
                PasswordHistory::recordPassword($user->id, $user->password);
            }
            
            // Set any additional attributes
            $user->email_verified_at = now(); // Auto-verify admin users
            $user->save();
            
            DB::commit();
            
            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'created_by' => auth()->id(),
            ]);

            return $user;
            
        } catch (Throwable $e) {
            DB::rollBack();
            
            $errorMessage = $this->getErrorMessage($e);
            
            Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'email' => $data['email'] ?? 'unknown',
                'created_by' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->danger()
                ->title('Error creating user')
                ->body($errorMessage)
                ->persistent()
                ->send();

            throw $e;
        }
    }
    
    protected function getErrorMessage(Throwable $e): string
    {
        // Provide user-friendly error messages
        if ($e instanceof ValidationException) {
            return 'Please check the form for validation errors.';
        }
        
        if (str_contains($e->getMessage(), 'Duplicate entry') || str_contains($e->getMessage(), 'unique')) {
            return 'A user with this email address already exists.';
        }
        
        if (str_contains($e->getMessage(), 'password')) {
            return 'There was an error with the password. Please ensure it meets all security requirements.';
        }
        
        if (str_contains($e->getMessage(), 'Connection refused') || str_contains($e->getMessage(), 'database')) {
            return 'Database connection error. Please try again or contact support.';
        }
        
        // Generic message for other errors
        return 'An unexpected error occurred while creating the user. Please try again or contact support if the problem persists.';
    }
    
    protected function beforeCreate(): void
    {
        // Additional validation or setup before creating
        $data = $this->data;
        
        // Check if we've reached a user limit (example)
        $userCount = static::getModel()::count();
        $maxUsers = config('app.max_users', 1000);
        
        if ($userCount >= $maxUsers) {
            Notification::make()
                ->danger()
                ->title('User limit reached')
                ->body("The maximum number of users ({$maxUsers}) has been reached.")
                ->persistent()
                ->send();
                
            $this->halt();
        }
    }
}
