<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R017NaskahBukuBahasaTerbitEdarNa extends Model
{
    use HasFactory;
    protected $table = [
        'r017_naskah_buku_bahasa_terbit_edar_nas'
    ];
    protected $fillable = [
        'periode_id','nip','judul_buku','isbn','is_bkd','is_verified','point'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
