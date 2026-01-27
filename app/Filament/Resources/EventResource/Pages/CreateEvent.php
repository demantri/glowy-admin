<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['original_image'])) {
            $filename = basename($data['original_image']);
            $thumbnailPath = 'events/thumbnails/' . $filename;

            // Pastikan direktori thumbnail ada
            if (!Storage::disk('public')->exists('events/thumbnails')) {
                Storage::disk('public')->makeDirectory('events/thumbnails');
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
