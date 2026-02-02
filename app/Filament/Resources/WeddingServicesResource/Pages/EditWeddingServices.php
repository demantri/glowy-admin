<?php

namespace App\Filament\Resources\WeddingServicesResource\Pages;

use App\Filament\Resources\WeddingServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeddingServices extends EditRecord
{
    protected static string $resource = WeddingServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
