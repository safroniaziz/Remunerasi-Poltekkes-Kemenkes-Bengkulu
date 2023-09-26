<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R012MembimbingPkm extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','tingkat_pkm','juara_ke','jumlah_pembimbing','is_bkd','is_verified','point','keterangan'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
