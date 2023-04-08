<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_Ewmp extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_rubrik','slug','nama_tabel_rubrik','kelompok_rubrik_id','ewmp','is_active'
    ];
    public function kelompokRubriks(){
        return $this->belongsTo(KelompokRubrik::class);
    }
}
