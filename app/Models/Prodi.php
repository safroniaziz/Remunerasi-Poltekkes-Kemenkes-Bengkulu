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
    
    public function dosens()
    {
        return $this->hasMany(Pegawai::class, 'id_prodi_homebase','id_prodi');
    }
}
