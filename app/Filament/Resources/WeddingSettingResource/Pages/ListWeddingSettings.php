<?php

namespace App\Filament\Resources\WeddingSettingResource\Pages;

use App\Filament\Resources\WeddingSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeddingSettings extends ListRecords
{
    protected static string $resource = WeddingSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
