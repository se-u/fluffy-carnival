<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPoli extends Model
{
    protected $table = 'daftar_poli';

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
        'status',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PERIKSA = 'periksa';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_BAYAR = 'bayar';
    public const STATUS_LUNAS = 'lunas';

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    public function periksas()
    {
        return $this->hasMany(Periksa::class, 'id_daftar_poli');
    }

    public function isActive()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PERIKSA]);
    }

    public function canRegisterNew()
    {
        return $this->status === self::STATUS_SELESAI || $this->status === self::STATUS_LUNAS;
    }
}
