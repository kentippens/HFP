<?php

namespace App\Filament\Resources\CorePageResource\Pages;

use App\Filament\Resources\CorePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorePages extends ListRecords
{
    protected static string $resource = CorePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
