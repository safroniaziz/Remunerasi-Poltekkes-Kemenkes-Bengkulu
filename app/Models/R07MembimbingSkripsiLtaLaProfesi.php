<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R07MembimbingSkripsiLtaLaProfesi extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','jumlah_mahasiswa','pembimbing_ke','is_bkd','is_verified','point','keterangan'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
