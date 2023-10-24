<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatanDt extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $casts = [ 'tmt_jabatan_dt'=>'datetime'];

    protected $fillable = [
        'nip','jabatan_dt_id','nama_jabatan_dt','slug','tmt_jabatan_dt','is_active'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }

    public function jabatanDt()
    {
        return $this->belongsTo(JabatanDt::class,'jabatan_dt_id');
    }
}
