<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok_Rubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kelompok_rubrik','is_active'
    ];
    public function nilaiEwmps(){
        return $this->hasMany(NilaiEwmp::class,'kelompok_rubrik_id');
    }
}
