<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatanFungsional extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $casts = [ 'tmt_jabatan_fungsional'=>'datetime'];
    protected $fillable = [
        'nip','jabatan_ds_id','nama_jabatan_fungsional','tmt_jabatan_fungsional','is_active','slug'
    ];
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }

    public function jabatanFungsional()
    {
        return $this->belongsTo(JabatanDs::class,'jabatan_ds_id');
    }
}
