<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_dokumen','nama_file_dokumen','tanggal_dokumen','is_active','slug'
    ];
}
