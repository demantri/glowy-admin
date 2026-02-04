<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\WhyChooseUs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WhyChooseUsResource\Pages;
use App\Filament\Resources\WhyChooseUsResource\RelationManagers;

class WhyChooseUsResource extends Resource
{
    protected static ?string $model = WhyChooseUs::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Event Organizer';
    protected static ?string $navigationLabel = 'Why Choose Us';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->description === 'admin_eo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role?->description === 'admin_eo' || auth()->user()?->role?->description === 'superadmin';
    }

    public static function canCreate(): bool
    {
        return \App\Models\WhyChooseUs::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Header Content')
                    ->schema([
                        TextInput::make('title')
                            ->required(),

                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Images')
                    ->schema([
                        FileUpload::make('image_main')
                            ->label('Main Image')
                            ->image()
                            ->directory('why'),

                        FileUpload::make('image_top')
                            ->label('Top Image')
                            ->image()
                            ->directory('why'),

                        FileUpload::make('image_bottom')
                            ->label('Bottom Image')
                            ->image()
                            ->directory('why'),
                    ])
                    ->columns(3),

                Section::make('Why Choose List')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                            ])
                            ->orderable('position')
                            // ->defaultItems(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                ImageColumn::make('image_main')->disk('public')->label('Main'),
                TextColumn::make('items_count')->counts('items')->label('Total Items'),
                TextColumn::make('updated_at')->dateTime('d M Y H:i'),
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
            'index' => Pages\ListWhyChooseUs::route('/'),
            'create' => Pages\CreateWhyChooseUs::route('/create'),
            'edit' => Pages\EditWhyChooseUs::route('/{record}/edit'),
        ];
    }
}
