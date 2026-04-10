<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'periksa';

    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
        'bukti_bayar',
    ];

    protected $casts = [
        'biaya_periksa' => 'integer',
        'tgl_periksa' => 'date',
    ];

    public function daftarPoli()
    {
        return $this->belongsTo(DaftarPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function getObatListAttribute()
    {
        return $this->detailPeriksas->map(function ($detail) {
            return $detail->obat;
        });
    }

    public function getTotalBiayaAttribute()
    {
        $biayaPeriksa = $this->biaya_periksa ?? 0;
        $biayaObat = $this->detailPeriksas->sum(function ($detail) {
            return $detail->obat->harga ?? 0;
        });
        return $biayaPeriksa + $biayaObat;
    }
}
