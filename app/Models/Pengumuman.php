<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'tanggal_pengumuman' => 'date',
    ];

    protected $fillable = [
        'judul_pengumuman','isi_pengumuman','slug','tanggal_pengumuman','file_pengumuman'
    ];

    public function getShortIsiPengumumanAttribute(){
        return substr($this->isi_pengumuman, 0, random_int(180,200)). '...';
    }
}
