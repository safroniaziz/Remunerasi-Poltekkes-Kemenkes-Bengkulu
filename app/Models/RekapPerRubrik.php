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
        'jumlah_data_seluruh',
        'jumlah_point_seluruh',
        'jumlah_data_terhitung',
        'jumlah_data_tidak_terhitung',
        'jumlah_point_tidak_terhitung',
    ];

    public function periode(){
        return $this->belongsTo(Periode::class,'periode_id');
    }

    public function getPeriodeFullnameAttribute(){
        return $this->periode->nama_periode;
    }
}
