<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    
    protected $table = 'users';

    protected $fillable = [
    'nama',
    'email',
    'password',
    'role',
    'profil',
    ];

    protected $hidden = [
        'password',
    ];

    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function canAccessPanel(Panel $panel):bool 
    {
        return $this->role === 'admin';
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class, 'id_user');
    }
    
    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_user');
    }
    
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_user');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
