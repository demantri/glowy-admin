<?php

namespace App\Filament\Resources\WeddingServiceItemResource\Pages;

use App\Filament\Resources\WeddingServiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeddingServiceItem extends EditRecord
{
    protected static string $resource = WeddingServiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
