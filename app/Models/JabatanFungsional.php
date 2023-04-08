<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanFungsional extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip','nama_jabatan_fungsional','tmt_jabatan_fungsional','is_active','slug'
    ];
    public function pegawais(){
        return $this->belongsTo(Pegawai::class);
    }
}
