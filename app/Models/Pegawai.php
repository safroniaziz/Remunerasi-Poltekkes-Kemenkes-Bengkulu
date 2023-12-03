<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    
    protected $guard = 'pegawai'; // Sesuaikan dengan nama guard yang Anda tentukan
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'nip',
        'nidn',
        'id_prodi_homebase',
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['total_point'];

    public function prodi(){
        return $this->belongsTo(Prodi::class, 'id_prodi_homebase','id_prodi');
    }

    public function jabatanFungsionals(){
        return $this->hasMany(RiwayatJabatanFungsional::class,'nip');
    }

    public function pangkatGolongans(){
        return $this->hasMany(PangkatGolongan::class,'nip');
    }
    public function riwayatJabatanDts(){
        return $this->hasMany(RiwayatJabatanDt::class,'nip');
    }
    public function rekapDaftarNominatifs(){
        return $this->hasMany(RekapDaftarNominatif::class,'nip');
    }
    public function presensis(){
        return $this->hasMany(Presensi::class,'nip');
    }

    public function riwayatPoints(){
        return $this->hasMany(RiwayatPoint::class, 'nip')
            ->where('point', '>', 0)
            ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(nama_rubrik, 'Rubrik ', -1), ' ', 1) AS DECIMAL) ASC");
    }

    public function riwayatPointAlls(){
        return $this->hasMany(RiwayatPoint::class, 'nip')
            ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(nama_rubrik, 'Rubrik ', -1), ' ', 1) AS DECIMAL) ASC");
    }

    public function getTotalPointAttribute(){
        return $this->riwayatPoints()->sum('point');
    }

    public function getTotalJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->where('is_active',1)->count();
    }

    public function getNamaJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->select('nama_jabatan_fungsional')->where('is_active',1)->orderBy('created_at','desc')->pluck('nama_jabatan_fungsional')->first();
    }

    public function getGradeJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanFungsional
        ->grade;
    }

    public function getGajiBluJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanFungsional
        ->gaji_blu;
    }

    public function getHargaPointJabatanFungsionalAktifAttribute(){
        return $this->jabatanFungsionals()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanFungsional
        ->harga_point_ds;
    }

    
    public function getTotalPangkatGolonganAktifAttribute(){
        return $this->pangkatGolongans()->where('is_active',1)->count();
    }

    public function getNamaPangkatGolonganAktifAttribute(){
        return $this->pangkatGolongans()->select('nama_pangkat')->where('is_active',1)->orderBy('created_at','desc')->pluck('nama_pangkat')->first();
    }

    public function getTotalJabatanDtAktifAttribute(){
        return $this->riwayatJabatanDts()->where('is_active',1)->count();
    }

    public function getNamaJabatanDtAktifAttribute(){
        return $this->riwayatJabatanDts()->select('nama_jabatan_dt')->where('is_active',1)->orderBy('created_at','desc')->pluck('nama_jabatan_dt')->first();
    }

    public function getGradeJabatanDtAktifAttribute(){
        return $this->riwayatJabatanDts()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanDt
        ->grade;
    }

    public function getGajiBluJabatanDtAktifAttribute(){
        return $this->riwayatJabatanDts()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanDt
        ->gaji_blu;
    }

    public function getHargaPointJabatanDtAktifAttribute(){
        return $this->riwayatJabatanDts()->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first()
        ->jabatanDt
        ->harga_point_dt;
    }

    public function jumlahPoint()
    {
        return $this->hasOne(RekapPerDosen::class,'nip','nip');
    }
}
