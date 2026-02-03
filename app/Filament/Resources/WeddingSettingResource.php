<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\WeddingSetting;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WeddingSettingResource\Pages;
use App\Filament\Resources\WeddingSettingResource\RelationManagers;

class WeddingSettingResource extends Resource
{
    protected static ?string $model = WeddingSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wedding Organizer';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?int $navigationSort = 19;

    public static function canCreate(): bool
    {
        return WeddingSetting::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make('Identitas & Logo')
                            ->schema([
                                TextInput::make('company_name')
                                    ->required()
                                    ->maxLength(255),
                                    
                                Section::make('Branding Media')
                                    ->description('Kelola aset visual website')
                                    ->schema([
                                        FileUpload::make('logo')
                                            ->image()
                                            ->directory('site-assets')
                                            ->imagePreviewHeight('150')
                                            ->helperText('Logo utama website'),

                                        FileUpload::make('favicon')
                                            ->image()
                                            ->directory('site-assets')
                                            ->maxSize(512) // Favicon kecil saja
                                            ->helperText('Ikon kecil untuk tab browser'),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Kontak & Sosmed')
                            ->schema([
                                TextInput::make('email')
                                    ->email(),

                                TextInput::make('whatsapp')
                                    ->tel()
                                    ->label('WhatsApp'),

                                Textarea::make('address')
                                    ->columnSpanFull()
                                    ->label('Office Location'),

                                TextInput::make('instagram')
                                    ->prefix('instagram.com/'),

                                TextInput::make('tiktok')
                                    ->prefix('tiktok.com/@'),

                                TextInput::make('youtube')
                                    ->prefix('youtube.com/c/'),
                            ])->columns(2),

                        Tabs\Tab::make('Footer')
                            ->schema([
                                TextInput::make('subtitle')
                                    ->label('Subtitle')
                                    ->required(),

                                TextInput::make('tagline')
                                    ->label('Tag Line')
                                    ->required(),
                            ])->columns(2),

                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('company_name')->searchable(),
                Tables\Columns\TextColumn::make('whatsapp'),
                Tables\Columns\TextColumn::make('email'),
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
