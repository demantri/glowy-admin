<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RolesResource\Pages;
use App\Filament\Resources\RolesResource\RelationManagers;
use App\Models\Roles;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RolesResource extends Resource
{
    protected static ?string $model = Roles::class;
    protected static ?string $navigationIcon = 'heroicon-c-shield-check';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?int $navigationSort = 30;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->description === 'superadmin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role?->description === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRoles::route('/create'),
            'edit' => Pages\EditRoles::route('/{record}/edit'),
        ];
    }
}
