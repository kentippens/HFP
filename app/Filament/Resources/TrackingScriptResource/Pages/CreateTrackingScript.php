<?php

namespace App\Filament\Resources\TrackingScriptResource\Pages;

use App\Filament\Resources\TrackingScriptResource;
use App\Services\TrackingScriptService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CreateTrackingScript extends CreateRecord
{
    protected static string $resource = TrackingScriptResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function afterCreate(): void
    {
        // Clear cache after creating a new script
        app(TrackingScriptService::class)->clearCache();
        
        // Validate the created script
        try {
            $this->record->validateModel();
            
            Notification::make()
                ->title('Script Created Successfully')
                ->body('The tracking script has been created and validated.')
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Script Created with Warnings')
                ->body('Script created but validation failed: ' . $e->getMessage())
                ->warning()
                ->send();
        }
    }
    
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Validation Error')
                ->body('Failed to create script: ' . $e->getMessage())
                ->danger()
                ->send();
            throw $e;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Creation Error')
                ->body('An unexpected error occurred while creating the script.')
                ->danger()
                ->send();
            throw $e;
        }
    }
}
