<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPoint extends Model
{
    use HasFactory;
    protected $fillable = [
       'rubrik_id','periode_id','nip','point'
    ];
}
