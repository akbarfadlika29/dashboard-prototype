<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Seksi;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function seksi()
    {
        return $this->belongsToMany(Seksi::class, 'user_seksi');
    }

    public function isSuperadmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdminUmum()
    {
        return $this->role === 'admin_umum';
    }

    public function isAdminSeksi()
    {
        return $this->role === 'admin_seksi';
    }

    public function isKepalaSeksi()
    {
        return $this->role === 'kepala_seksi';
    }
}
