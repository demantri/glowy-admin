<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Wedding\Identity;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\IdentityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\IdentityResource\RelationManagers;

class IdentityResource extends Resource
{
    protected static ?string $model = Identity::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Identity';
    protected static ?int $navigationSort = 12;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->description === 'admin_wo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role?->description === 'admin_wo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function canCreate(): bool
    {
        return Identity::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                Textarea::make('subtitle'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),

                TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->limit(300)
                    ->searchable()
                    ->sortable()
                    ->wrap(),
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
            'index' => Pages\ListIdentities::route('/'),
            'create' => Pages\CreateIdentity::route('/create'),
            'edit' => Pages\EditIdentity::route('/{record}/edit'),
        ];
    }
}
