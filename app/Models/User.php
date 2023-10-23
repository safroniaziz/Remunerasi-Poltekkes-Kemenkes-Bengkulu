<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_nip',
        'nama_user',
        'kodefak',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeVerifikator(Builder $query)
    {
        return $query->role('verifikator');
    }

    public function scopeAdministrator(Builder $query)
    {
        return $query->role('administrator');
    }

    public function getJurusanAttribute()
    {
        // Misalkan $this->kodefak adalah kodefak yang ingin Anda cari di tabel prodis
        $kodefak = $this->kodefak;

        // Query untuk mendapatkan nmfak dari tabel prodis berdasarkan kodefak
        return DB::table('prodis')
            ->where('kodefak', $kodefak)
            ->value('nmfak');
    }
}
