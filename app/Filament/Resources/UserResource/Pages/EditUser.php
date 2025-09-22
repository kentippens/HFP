<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('resetPassword')
                ->label('Reset Password')
                ->icon('heroicon-o-key')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Force Password Reset')
                ->modalDescription('This will require the user to change their password on next login.')
                ->action(function () {
                    try {
                        $this->record->update(['force_password_change' => true]);
                        
                        Notification::make()
                            ->success()
                            ->title('Password reset required')
                            ->body('User will be required to change password on next login.')
                            ->send();
                            
                        Log::info('Password reset forced for user', [
                            'user_id' => $this->record->id,
                            'email' => $this->record->email,
                            'forced_by' => auth()->id(),
                        ]);
                    } catch (Throwable $e) {
                        Log::error('Failed to force password reset', [
                            'user_id' => $this->record->id,
                            'error' => $e->getMessage()
                        ]);
                        
                        Notification::make()
                            ->danger()
                            ->title('Action failed')
                            ->body('Could not force password reset. Please try again.')
                            ->send();
                    }
                }),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete User')
                ->modalDescription('Are you sure you want to delete this user? This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, delete user')
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('User deleted')
                        ->body('The user has been successfully deleted.')
                ),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Don't show the hashed password
        unset($data['password']);
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            // Handle password update with proper validation
            if (isset($data['password']) && filled($data['password'])) {
                // The password will be hashed by the form field's dehydrateStateUsing
                // But we need to check password history
                if ($this->record->isPasswordInHistory($data['password'])) {
                    Notification::make()
                        ->danger()
                        ->title('Password update failed')
                        ->body('This password has been used recently. Please choose a different password.')
                        ->persistent()
                        ->send();
                    
                    // Throw validation exception to prevent save
                    throw ValidationException::withMessages([
                        'password' => ['This password has been used recently.']
                    ]);
                }
                
                // Update password changed at and reset force change flag
                $data['password_changed_at'] = now();
                $data['force_password_change'] = false;
                
                // Record the password in history
                if ($this->record->password) {
                    \App\Models\PasswordHistory::recordPassword($this->record->id, $this->record->password);
                }
            } else {
                // Remove password field if empty
                unset($data['password']);
            }
            
            // Always remove confirmation field
            unset($data['password_confirmation']);
            
            return $data;
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Error in mutateFormDataBeforeSave', [
                'user_id' => $this->record->id,
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::beginTransaction();
        
        try {
            // Validate data types and required fields
            $this->validateUpdateData($data);
            
            // Update the record
            $record->update($data);
            
            // Clean up old password history if password was changed
            if (isset($data['password'])) {
                \App\Models\PasswordHistory::cleanupOldEntries(
                    $record->id, 
                    config('security.auth.password.history_count', 5)
                );
            }
            
            DB::commit();
            
            Log::info('User updated successfully', [
                'user_id' => $record->id,
                'email' => $record->email,
                'updated_by' => auth()->id(),
                'fields_updated' => array_keys($data)
            ]);

            return $record;
            
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();
            
            Log::error('Failed to update user', [
                'error' => $e->getMessage(),
                'user_id' => $record->id,
                'data' => array_keys($data), // Don't log sensitive data
                'updated_by' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->danger()
                ->title('Error updating user')
                ->body($this->getErrorMessage($e))
                ->persistent()
                ->send();

            throw $e;
        }
    }
    
    protected function validateUpdateData(array $data): void
    {
        // Ensure critical fields are not accidentally nulled
        $protectedFields = ['email', 'name'];
        foreach ($protectedFields as $field) {
            if (array_key_exists($field, $data) && empty($data[$field])) {
                throw ValidationException::withMessages([
                    $field => ["The {$field} field cannot be empty."]
                ]);
            }
        }
    }
    
    protected function getErrorMessage(Throwable $e): string
    {
        // Provide user-friendly error messages
        if ($e instanceof ValidationException) {
            return 'Please check the form for validation errors.';
        }
        
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            return 'This email address is already in use.';
        }
        
        if (str_contains($e->getMessage(), 'password')) {
            return 'There was an error updating the password. Please ensure it meets all requirements.';
        }
        
        // Generic message for other errors
        return 'An unexpected error occurred. Please try again or contact support if the problem persists.';
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User updated successfully')
            ->body('The user information has been saved.')
            ->duration(5000);
    }
    
    protected function getRedirectUrl(): string
    {
        // Redirect to index after save
        return $this->getResource()::getUrl('index');
    }
}
