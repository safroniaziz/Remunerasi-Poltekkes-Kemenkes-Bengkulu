<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R07MembimbingSkripsiLtaLaProfesi extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','jumlah_mahasiswa','pembimbing_ke','is_bkd','is_verified','point'
    ];
    public function periodes(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
