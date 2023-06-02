<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R022ReviewerEclerePenelitianMh extends Model
{
    use HasFactory;
    protected $table = [
        'r022_reviewer_eclere_penelitian_mhs'
    ];
    protected $fillable = [
        'periode_id','nip','judul_protokol_penelitian','is_bkd','is_verified','point'
    ];
    public function periode(){
        return $this->belongsTo(Periode::class);
    }
    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'nip');
    }
}
