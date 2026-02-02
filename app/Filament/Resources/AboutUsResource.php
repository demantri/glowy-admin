<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\AboutUs;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AboutUsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AboutUsResource\RelationManagers;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Event Organizer';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return \App\Models\AboutUs::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(150),

                        RichEditor::make('description')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->image()
                            ->directory('about')
                            ->imagePreviewHeight('200')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Vision')
                    ->schema([
                        TextInput::make('vision_title')
                            ->required(),

                        RichEditor::make('vision_content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Mission')
                    ->schema([
                        TextInput::make('mission_title')
                            ->required(),

                        Repeater::make('missions')
                            ->relationship()
                            ->schema([
                                RichEditor::make('content')
                                    ->required()
                                    ->label('Mission Description'),
                            ])
                            ->orderable('position')
                            ->defaultItems(1)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->height(60)
                    ->circular(),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vision_title')
                    ->label('Vision')
                    ->limit(30),

                TextColumn::make('missions_count')
                    ->label('Total Mission')
                    ->counts('missions'),

                TextColumn::make('updated_at')
                    ->label('Last Update')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}
