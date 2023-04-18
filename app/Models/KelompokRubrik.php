<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokRubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kelompok_rubrik','slug','is_active'
    ];
    public function nilaiEwmps(){
        return $this->hasMany(NilaiEwmp::class,'kelompok_rubrik_id');
    }
}
