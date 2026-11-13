<?php

namespace App\Filament\Psikolog\Pages;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProfilSaya extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.psikolog.pages.profil-saya';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            Auth::user()->psikolog->only([
                'nama', 'spesialis', 'deskripsi_psikolog', 'foto_profil', 'biaya', 'email',
            ])
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(255),
                TextInput::make('email')->label('Email (untuk login)')->disabled()->dehydrated(false),
                TextInput::make('spesialis')->label('Spesialisasi')->required()->maxLength(255),
                TextInput::make('biaya')->label('Biaya per Sesi')->prefix('Rp')
                    ->disabled()->dehydrated(false)
                    ->helperText('Tarif diatur oleh admin.'),
                Textarea::make('deskripsi_psikolog')->label('Deskripsi')->rows(5)->columnSpanFull(),
                FileUpload::make('foto_profil')
                    ->label('Foto Profil')
                    ->image()->avatar()
                    ->disk('foto')->directory('psikolog')->visibility('public')
                    ->imageEditor()->columnSpanFull(),
                TextInput::make('password')
                    ->label('Password Baru')
                    ->password()->revealable()->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan jika tidak ingin mengganti password.')
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function simpan(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // users.nama ikut tersinkron lewat hook saved() di model Psikolog
        $user->psikolog->update(
            Arr::only($data, ['nama', 'spesialis', 'deskripsi_psikolog', 'foto_profil'])
        );

        if (filled($data['password'] ?? null)) {
            $user->update(['password' => $data['password']]); // di-hash otomatis oleh cast

            // Supaya tidak ter-logout setelah ganti password
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $user->getAuthPassword(),
            ]);
        }

        $this->form->fill(array_merge($this->data, ['password' => null]));

        Notification::make()->title('Profil berhasil disimpan')->success()->send();
    }
}