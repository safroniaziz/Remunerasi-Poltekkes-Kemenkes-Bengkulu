<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanDt extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip','nama_jabatan_dt','slug','grade','harga_point_dt','job_value','pir','harga_jabatan','gaji_blu','insentif_maximum'
    ];
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
