<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Wedding\Service;
use Filament\Resources\Resource;
use App\Models\Wedding\ServiceSection;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Wedding\WeddingServiceItem;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WeddingServiceItemResource\Pages;
use App\Filament\Resources\WeddingServiceItemResource\RelationManagers;

class WeddingServiceItemResource extends Resource
{
    protected static ?string $model = ServiceSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Service Section';
    protected static ?int $navigationSort = 13;

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
        return Service::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label('Section Title'),

                Textarea::make('subtitle')
                    ->label('Section Subtitle')
                    ->rows(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),

                TextColumn::make('subtitle')
                    ->limit(100)
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
            'index' => Pages\ListWeddingServiceItems::route('/'),
            'create' => Pages\CreateWeddingServiceItem::route('/create'),
            'edit' => Pages\EditWeddingServiceItem::route('/{record}/edit'),
        ];
    }
}
