<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_prodi'; // Primary key adalah 'id_prodi'
    public $incrementing = false; // Primary key tidak auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_prodi',
        'verifikator_nip',
        'penanggung_jawab_nip',
        'kdjen',
        'kdpst',
        'nama_jenjang',
        'nama_prodi',
        'nama_lengkap_prodi',
        'kodefak',
        'nmfak',
    ];
    
    public function dosens()
    {
        return $this->hasMany(Pegawai::class, 'id_prodi_homebase','id_prodi');
    }

    public function verifikator()
    {
        return $this->belongsTo(Pegawai::class,'verifikator_nip');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(Pegawai::class,'penanggung_jawab_nip');
    }
}
