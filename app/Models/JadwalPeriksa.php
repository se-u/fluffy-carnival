<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'no_antrian_sekarang',
    ];

    protected $casts = [
        'no_antrian_sekarang' => 'integer',
    ];

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function daftarPolis()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }

    public function getNextAntrian()
    {
        $this->no_antrian_sekarang++;
        $this->save();
        return $this->no_antrian_sekarang;
    }

    public function getRemainingQueueCount()
    {
        return $this->daftarPolis()
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'lunas')
            ->where('no_antrian', '>', $this->no_antrian_sekarang)
            ->count();
    }
}
