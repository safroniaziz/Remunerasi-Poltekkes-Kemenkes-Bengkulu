<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R013OrasiIlmiahNarasumberBidangIlmu extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','judul_kegiatan','tingkatan_ke','is_bkd','is_verified','point'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
