<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'periode_siakad_id','nama_periode','slug','semester','is_active','tahun_ajaran','bulan_pembayaran','bulan'
    ];
    public function rekapDaftarNominatifs(){
        return $this->hasMany(RekapDaftarNominatif::class,'periode_id');
    }
    public function presensis(){
        return $this->hasMany(Presensi::class,'periode_id');
    }

}
