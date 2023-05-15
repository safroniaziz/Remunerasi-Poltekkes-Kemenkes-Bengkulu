<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PangkatGolongan extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [ 'tmt_pangkat_golongan'=>'datetime'];
    protected $fillable = [
        'nip','nama_pangkat','slug','golongan','tmt_pangkat_golongan','is_active'
    ];
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
