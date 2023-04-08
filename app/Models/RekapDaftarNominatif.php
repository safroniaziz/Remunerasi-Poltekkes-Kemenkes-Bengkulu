<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapDaftarNominatif extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','nama','slug','nomor_rekening','npwp','jabatan_dt','jabatan_ds','golongan','kelas','jurusan','total_point','remun_p1','remun_p2','total_remun','faktor_pengurang_pph','remun_dibayarkan'
    ];

    public function periodes(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
