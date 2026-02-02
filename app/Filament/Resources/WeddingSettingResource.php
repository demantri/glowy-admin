<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingSettingResource\Pages;
use App\Filament\Resources\WeddingSettingResource\RelationManagers;
use App\Models\WeddingSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeddingSettingResource extends Resource
{
    protected static ?string $model = WeddingSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?int $navigationSort = 19;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListWeddingSettings::route('/'),
            'create' => Pages\CreateWeddingSetting::route('/create'),
            'edit' => Pages\EditWeddingSetting::route('/{record}/edit'),
        ];
    }
}
