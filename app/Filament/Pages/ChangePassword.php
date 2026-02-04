<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Ganti Password';
    protected static ?string $navigationGroup = 'User Management';
    protected static string $view = 'filament.pages.change-password';
    protected static ?int $navigationSort = 33;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\TextInput::make('current_password')
                    ->label('Password Saat Ini')
                    ->password()
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password Baru')
                    ->password()
                    ->required()
                    ->confirmed()
                    ->minLength(6),

                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->required(),
            ]);
    }

    public function submit()
    {
        $user = auth()->user();
        $data = $this->form->getState();

        // cek password lama
        if (! Hash::check($data['current_password'], $user->password)) {
            Notification::make()
                ->title('Password lama salah')
                ->danger()
                ->send();

            return;
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->form->fill([]);

        Notification::make()
            ->title('Password berhasil diganti')
            ->success()
            ->send();
    }
}