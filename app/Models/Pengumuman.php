<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_pengumuman','isi_pengumuman','file_pengumuman','slug','tanggal_pengumuman','is_active'
    ];
}
