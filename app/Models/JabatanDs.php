<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanDs extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jabatan_ds','grade','harga_point_ds','job_value','pir','harga_jabatan','gaji_blu','insentif_maximum','slug'
    ];
}
