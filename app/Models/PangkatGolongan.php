<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PangkatGolongan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip','nama_pangkat','slug','golongan','tmt_pangkat_golongan','is_active'
    ];
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
