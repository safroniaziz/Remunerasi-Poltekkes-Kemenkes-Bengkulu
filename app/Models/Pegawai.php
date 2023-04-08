<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nip',
        'nidn',
        'nama',
        'slug',
        'email',
        'jenis_kelamin',
        'jurusan',
        'nomor_rekening',
        'npwp',
        'is_serdos',
        'no_sertifikat_serdos',
        'no_whatsapp',
        'is_active',
    ];
}
