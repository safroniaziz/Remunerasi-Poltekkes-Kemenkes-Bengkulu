<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R029MemperolehPenghargaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id','nip','judul_penghargaan','is_bkd','is_verified','point','keterangan'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
