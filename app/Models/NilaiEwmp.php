<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiEwmp extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'nama_rubrik','nama_tabel_rubrik','kelompok_rubrik_id','ewmp','is_active'
    ];
    public function kelompokRubrik(){
        return $this->belongsTo(KelompokRubrik::class);
    }
}
