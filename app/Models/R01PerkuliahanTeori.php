<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class R01PerkuliahanTeori extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'periode_id','nip','jumlah_tatap_muka','jumlah_sks','jumlah_mahasiswa','jumlah_tatap_muka','is_bkd','is_verified','point'
    ];
    public function periodes(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
