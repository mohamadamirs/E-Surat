<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

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
        'name',
        'email',
        'password',
        'role',
        'jenis_kelamin',
        'profile_photo_path',
        'nomer_hp',
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

    public function getProfilePhoto()
    {
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_path)) {
            $path = storage_path('app/public/' . $this->profile_path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        // fallback ke SVG default
        return $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        // SVG dasar dengan siluet pengguna
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function getDashboard(): string
    {
        if ($this->role === 'admin') {
            return 'admin.dashboard';
        }

        if ($this->role === 'kepala') {
            return 'kepala.dashboard'; // Sesuaikan
        }

        if ($this->role === 'sekretaris') {
            return 'sekretaris.dashboard'; // Sesuaikan

        }
        return 'login';
    }

    // relasi dataabase

    public function suratMasukDikelola()
    {
        return $this->hasMany(SuratMasuk::class, 'user_id_pengelola');
    }

    // SATU User bisa mengelola BANYAK Surat Keluar
    public function suratKeluarDikelola()
    {
        return $this->hasMany(SuratKeluar::class, 'user_id_pengelola');
    }

    // SATU User (Sekretaris) bisa membuat BANYAK Disposisi
    public function disposisiDibuat()
    {
        return $this->hasMany(Disposisi::class, 'id_sekretaris');
    }

    // SATU User (Pimpinan) bisa memvalidasi BANYAK Disposisi
    public function disposisiDivalidasi()
    {
        return $this->hasMany(Disposisi::class, 'id_kepala');
    }

    public function getSapaan(): string
    {
        if ($this->jenis_kelamin === 'Laki-laki') {
            return 'Bapak';
        }

        if ($this->jenis_kelamin === 'Perempuan') {
            return 'Ibu';
        }
        return 'Bapak/Ibu';
    }
}
