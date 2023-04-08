<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pegawai extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nip',
        'nidn',
        'nama',
        'slug',
        'email',
        'jenis_kelamin',
        'jurusan',
        'nomor_rekening',
        'npwp',
        'is_serdos',
        'no_sertifikat_serdos',
        'no_whatsapp',
        'is_active',
    ];

    public function jabatanFungsionals(){
        return $this->hasMany(jabatanFungsional::class,'nip');
    }
    public function pangkatGolongans(){
        return $this->hasMany(PangkatGolongan::class,'nip');
    }
    public function riwayatJabatanDts(){
        return $this->hasMany(riwayatJabatanDt::class,'nip');
    }
    public function rekapDaftarNominatifs(){
        return $this->hasMany(RekapDaftarNominatif::class,'nip');
    }
    public function presensis(){
        return $this->hasMany(Presensi::class,'nip');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
}