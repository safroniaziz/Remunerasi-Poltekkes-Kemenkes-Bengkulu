<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JabatanDs extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nama_jabatan_ds','grade','harga_point_ds','gaji_blu','slug'
    ];
}