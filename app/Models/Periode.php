<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $casts = [
        'tanggal_awal' => 'datetime',
        'tanggal_akhir' => 'datetime',
    ];
    
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_periode','slug','semester','is_active','tahun_ajaran','bulan_pembayaran','bulan','tamggal_awal','tanggal_akhir'
    ];
    public function rekapDaftarNominatifs(){
        return $this->hasMany(RekapDaftarNominatif::class,'periode_id');
    }
    public function presensis(){
        return $this->hasMany(Presensi::class,'periode_id');
    }

    public function getTahunSemesterAttribute()
    {
        // Menggabungkan tahun_ajaran dan semester menjadi satu kolom
        return $this->attributes['tahun_ajaran'] . $this->attributes['semester'];
    }

}
