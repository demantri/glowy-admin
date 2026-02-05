<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Wedding\Homepage;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\HomepageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomepageResource\RelationManagers;

class HomepageResource extends Resource
{
    protected static ?string $model = Homepage::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Homepage';
    protected static ?int $navigationSort = 11;

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
        return Homepage::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),

                Textarea::make('subtitle')
                    ->required(),

                HasManyRepeater::make('images')
                    ->relationship()
                    ->label('Gambar Homepage')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->directory('homepage')
                            ->maxSize(2048) // 2MB
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth(1920)
                            ->imageResizeTargetHeight(1080)
                            ->imagePreviewHeight('150')
                            ->columnSpan(2)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(1)
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->orderable('sort_order')
                    ->minItems(1)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images.image_path')
                    ->label('Images')
                    ->stacked()
                    ->limit(3)
                    ->circular(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->limit(250)
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
            'index' => Pages\ListHomepages::route('/'),
            'create' => Pages\CreateHomepage::route('/create'),
            'edit' => Pages\EditHomepage::route('/{record}/edit'),
        ];
    }
}
