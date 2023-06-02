<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPerDosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'total_point',
    ];
}
