<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPerDosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'periode_id',
        'total_point',
    ];
    
    public function dosen()
    {
        return $this->belongsTo(Pegawai::class,'nip','nip');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class,'periode_id');
    }
}
