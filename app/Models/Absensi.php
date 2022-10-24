<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'absen_masuk',
        'absen_pulang',
        'keterangan_absen_masuk',
        'keterangan_absen_pulang',
        'status_absen_masuk',
        'status_absen_pulang',
        'keterlambatan_absen_masuk',
        'keterlambatan_absen_pulang',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
