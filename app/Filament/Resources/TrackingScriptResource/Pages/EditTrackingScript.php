<?php

namespace App\Filament\Resources\TrackingScriptResource\Pages;

use App\Filament\Resources\TrackingScriptResource;
use App\Services\TrackingScriptService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class EditTrackingScript extends EditRecord
{
    protected static string $resource = TrackingScriptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('validate')
                ->label('Validate Script')
                ->icon('heroicon-o-shield-check')
                ->color('info')
                ->action(function () {
                    try {
                        $this->record->validateModel();
                        Notification::make()
                            ->title('Script Valid')
                            ->body('The tracking script passed all validation checks.')
                            ->success()
                            ->send();
                    } catch (ValidationException $e) {
                        Notification::make()
                            ->title('Validation Failed')
                            ->body('Script validation failed: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('preview')
                ->label('Preview Script')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->action(function () {
                    $service = app(TrackingScriptService::class);
                    $rendered = $service->renderScript($this->record);
                    
                    if ($rendered) {
                        Notification::make()
                            ->title('Script Preview')
                            ->body('Script rendered successfully. Check browser console for details.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Preview Failed')
                            ->body('Script could not be rendered. Check logs for details.')
                            ->warning()
                            ->send();
                    }
                }),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function afterSave(): void
    {
        // Clear cache after saving changes
        app(TrackingScriptService::class)->clearCache();
        
        // Validate the updated script
        try {
            $this->record->validateModel();
            
            Notification::make()
                ->title('Script Updated Successfully')
                ->body('The tracking script has been updated and validated.')
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Script Updated with Warnings')
                ->body('Script updated but validation failed: ' . $e->getMessage())
                ->warning()
                ->send();
        }
    }
    
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Validation Error')
                ->body('Failed to update script: ' . $e->getMessage())
                ->danger()
                ->send();
            throw $e;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Update Error')
                ->body('An unexpected error occurred while updating the script.')
                ->danger()
                ->send();
            throw $e;
        }
    }
}
