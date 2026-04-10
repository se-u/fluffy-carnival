<?php

namespace App\Http\Controllers;

use App\Exports\DokterExport;
use App\Exports\PasienExport;
use App\Exports\ObatExport;
use App\Exports\JadwalPeriksaExport;
use App\Exports\RiwayatPasienExport;

class ExportController extends Controller
{
    public function dokter()
    {
        return (new DokterExport())->download();
    }

    public function pasien()
    {
        return (new PasienExport())->download();
    }

    public function obat()
    {
        return (new ObatExport())->download();
    }

    public function jadwalPeriksa()
    {
        return (new JadwalPeriksaExport())->download();
    }

    public function riwayatPasien()
    {
        return (new RiwayatPasienExport())->download();
    }
}
