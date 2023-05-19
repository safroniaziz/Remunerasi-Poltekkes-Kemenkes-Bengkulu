<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapDaftarNominatif extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'periode_id','nip','nama','slug','nomor_rekening','npwp','jabatan_dt','jabatan_ds','golongan','kelas','jurusan','total_point','remun_p1','remun_p2','total_remun','faktor_pengurang_pph','remun_dibayarkan'
    ];

    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
