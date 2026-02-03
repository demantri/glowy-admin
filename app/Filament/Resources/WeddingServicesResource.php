<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Wedding\Service;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WeddingServicesResource\Pages;
use App\Filament\Resources\WeddingServicesResource\RelationManagers;

class WeddingServicesResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Services';
    protected static ?int $navigationSort = 13;
    protected static bool $shouldRegisterNavigation = false;

    public static function canCreate(): bool
    {
        return Service::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('subtitle'),
                TextInput::make('icon')
                    ->helperText('Contoh: heroicon-o-cog'),
                TextInput::make('header_services'),
                Textarea::make('description'),
                Toggle::make('is_recommend')
                    ->label('Recommended Platform')
                    ->helperText('Tandai jika platform ini direkomendasikan')
                    ->default(false),
                TextInput::make('sort_order')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('icon'),
                ToggleColumn::make('is_recommend')
                    ->label('Recommend'),
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
            'index' => Pages\ListWeddingServices::route('/'),
            'create' => Pages\CreateWeddingServices::route('/create'),
            'edit' => Pages\EditWeddingServices::route('/{record}/edit'),
        ];
    }
}
