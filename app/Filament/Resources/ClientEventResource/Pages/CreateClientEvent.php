<?php

namespace App\Filament\Resources\ClientEventResource\Pages;

use Filament\Actions;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ClientEventResource;

class CreateClientEvent extends CreateRecord
{
    protected static string $resource = ClientEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['original_image'])) {
            $filename = basename($data['original_image']);
            $thumbnailPath = 'clients/thumbnails/' . $filename;

            // Pastikan direktori thumbnail ada
            if (!Storage::disk('public')->exists('clients/thumbnails')) {
                Storage::disk('public')->makeDirectory('clients/thumbnails');
            }

            // Ambil file original dari storage
            $fullPathOriginal = Storage::disk('public')->path($data['original_image']);

            // Proses Resize & Compress menggunakan Intervention Image
            Image::make($fullPathOriginal)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(Storage::disk('public')->path($thumbnailPath), 60); // Kualitas 60% agar < 1MB

            // Masukkan path thumbnail ke database
            $data['thumbnail'] = $thumbnailPath;
        }

        return $data;
    }
}
