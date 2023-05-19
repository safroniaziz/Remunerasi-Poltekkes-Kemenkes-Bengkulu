<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pegawai extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    
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
    public function riwayatPoints(){
        return $this->hasMany(RiwayatPoint::class,'nip');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }

    public function jabatanDt(){
        return $this->belongsTo(JabatanDt::class);
    }

    public function getTotalJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->where('is_active',1)->count();
    }

    public function getNamaJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->select('nama_jabatan_fungsional')->where('is_active',1)->orderBy('created_at','desc')->pluck('nama_jabatan_fungsional')->first();
    }
    
    public function getTotalPangkatGolonganAktifAttribute(){
        return $this->pangkatGolongans()->where('is_active',1)->count();
    }
}
