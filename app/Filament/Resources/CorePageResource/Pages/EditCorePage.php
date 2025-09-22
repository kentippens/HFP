<?php

namespace App\Filament\Resources\CorePageResource\Pages;

use App\Filament\Resources\CorePageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorePage extends EditRecord
{
    protected static string $resource = CorePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
