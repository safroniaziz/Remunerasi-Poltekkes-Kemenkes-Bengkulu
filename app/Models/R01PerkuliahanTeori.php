<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class R01PerkuliahanTeori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'periode_id','nip','nama_matkul','kode_kelas',
        'jumlah_tatap_muka','jumlah_sks','jumlah_mahasiswa'
        ,'jumlah_tatap_muka','id_prodi','is_bkd','is_verified'
        ,'sumber_data','point','created_at','deleted_at'
    ];
    
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }

    public function prodiMatkul(){
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}
