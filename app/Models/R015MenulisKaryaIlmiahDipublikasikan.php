<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R015MenulisKaryaIlmiahDipublikasikan extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','judul','penulis_ke','jenis','jumlah_penulis','is_bkd','is_verified','point'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
