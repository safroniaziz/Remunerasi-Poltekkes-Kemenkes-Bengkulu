<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPerRubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id',
        'nama_rubrik',
        'total_point',
    ];
}
