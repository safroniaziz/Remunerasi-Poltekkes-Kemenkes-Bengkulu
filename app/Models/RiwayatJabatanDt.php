<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatanDt extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip','nama_jabatan_dt','slug','tmt_jabatan_dt','is_active'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
