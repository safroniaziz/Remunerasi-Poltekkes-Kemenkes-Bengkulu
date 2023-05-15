<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R08MengujiSeminarProposalKtiLtaSkripsi extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','jumlah_mahasiswa','jenis','is_bkd','is_verified','point'
    ];
    public function periodes(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
