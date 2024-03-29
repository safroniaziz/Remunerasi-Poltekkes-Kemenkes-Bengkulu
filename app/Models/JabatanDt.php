<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JabatanDt extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nama_jabatan_dt','slug','grade','harga_point_dt','gaji_blu'
    ];
}
