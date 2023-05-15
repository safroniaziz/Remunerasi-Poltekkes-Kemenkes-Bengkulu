<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatanDt extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'nip','nama_jabatan_dt','slug','tmt_jabatan_dt','is_active'
    ];

    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
