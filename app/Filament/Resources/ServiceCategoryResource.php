<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ServiceCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceCategoryResource\Pages;
use App\Filament\Resources\ServiceCategoryResource\RelationManagers;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static ?string $navigationLabel = 'Service Categories';
    protected static ?string $navigationGroup = 'Event Organizer';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 5;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->description === 'admin_eo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role?->description === 'admin_eo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Service Categories')
                ->description('Masukan informasi utama mengenai layanan ini.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('icon')
                        ->helperText('Contoh: briefcase, megaphone, sparkles'),

                    TextInput::make('order')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->default(true),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('icon'),
                ToggleColumn::make('is_active'),
                TextColumn::make('order')->sortable(),
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
            'index' => Pages\ListServiceCategories::route('/'),
            'create' => Pages\CreateServiceCategory::route('/create'),
            'edit' => Pages\EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
