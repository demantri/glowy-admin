<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebsiteSettingResource\Pages;
use App\Models\WebsiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Components\Tab;

class WebsiteSettingResource extends Resource
{
    protected static ?string $model = WebsiteSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Event Organizer';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?int $navigationSort = 7;

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
        return \App\Models\WebsiteSetting::count() < 1;
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
                                TextInput::make('email')->email(),
                                TextInput::make('phone')->tel()->label('WhatsApp'),
                                Textarea::make('address')->columnSpanFull()->label('Office Location'),
                                TextInput::make('instagram')->prefix('instagram.com/'),
                                TextInput::make('tiktok')->prefix('tiktok.com/@'),
                                TextInput::make('youtube')->prefix('youtube.com/c/'),
                            ])->columns(2),

                        Tabs\Tab::make('Footer')
                            ->schema([
                                TextInput::make('subtitle')->label('Subtitle')->required(),
                                TextInput::make('tagline')->label('Tag Line')->required(),
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
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebsiteSettings::route('/'),
            'create' => Pages\CreateWebsiteSetting::route('/create'),
            'edit' => Pages\EditWebsiteSetting::route('/{record}/edit'),
        ];
    }
}
