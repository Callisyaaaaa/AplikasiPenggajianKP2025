<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'iduser',
        'name',
        'alamat',
        'nomor',
        'jabatan',
        'gaji',
        'status_pegawai',
        'status_menikah',
        'nik',
        'pendidikan',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'iduser');
    }

}
