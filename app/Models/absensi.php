<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'pegawai_name',      // Jika kamu simpan nama di tabel absensi, kalau nggak bisa dihapus
        'status',
        'attendance_photo',
        'attendance_time',
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
