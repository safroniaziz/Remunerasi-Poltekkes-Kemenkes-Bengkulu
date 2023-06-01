<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPerRubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id',
        'kode_rubrik',
        'nama_rubrik',
        'total_point',
    ];

    public function periode(){
        return $this->belongsTo(Periode::class,'periode_id');
    }

    public function getPeriodeFullnameAttribute(){
        return $this->periode->nama_periode;
    }
}
