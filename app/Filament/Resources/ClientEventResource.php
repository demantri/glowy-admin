<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClientEvent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientEventResource\Pages;
use App\Filament\Resources\ClientEventResource\RelationManagers;

class ClientEventResource extends Resource
{
    protected static ?string $model = ClientEvent::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Upload Client';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Event')
                    ->description('Masukkan informasi utama mengenai event ini.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Media Client')
                    ->description('Upload foto client. Pastikan thumbnail diupload untuk kecepatan website.')
                    ->schema([
                        FileUpload::make('original_image')
                            ->label('Upload Foto Client')
                            ->columnSpanFull()
                            ->image()
                            ->directory('clients/original')
                            ->disk('public')
                            ->maxSize(1028)
                            ->required(),

                        // Sembunyikan input thumbnail agar admin tidak perlu isi manual
                        Hidden::make('thumbnail'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail'),

                TextColumn::make('description')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientEvents::route('/'),
            'create' => Pages\CreateClientEvent::route('/create'),
            'edit' => Pages\EditClientEvent::route('/{record}/edit'),
        ];
    }
}
