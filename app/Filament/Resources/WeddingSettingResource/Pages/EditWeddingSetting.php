<?php

namespace App\Filament\Resources\WeddingSettingResource\Pages;

use App\Filament\Resources\WeddingSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeddingSetting extends EditRecord
{
    protected static string $resource = WeddingSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
