<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutMissionResource\Pages;
use App\Filament\Resources\AboutMissionResource\RelationManagers;
use App\Models\AboutMission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutMissionResource extends Resource
{
    protected static ?string $model = AboutMission::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'About Mission';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 2;

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
            'index' => Pages\ListAboutMissions::route('/'),
            'create' => Pages\CreateAboutMission::route('/create'),
            'edit' => Pages\EditAboutMission::route('/{record}/edit'),
        ];
    }
}
