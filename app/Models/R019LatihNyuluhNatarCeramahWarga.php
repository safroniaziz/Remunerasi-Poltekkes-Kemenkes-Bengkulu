<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R019LatihNyuluhNatarCeramahWarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','judul_kegiatan','jenis','is_bkd','is_verified','point'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
