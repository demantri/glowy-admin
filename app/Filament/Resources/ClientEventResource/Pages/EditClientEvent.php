<?php

namespace App\Filament\Resources\ClientEventResource\Pages;

use App\Filament\Resources\ClientEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientEvent extends EditRecord
{
    protected static string $resource = ClientEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
