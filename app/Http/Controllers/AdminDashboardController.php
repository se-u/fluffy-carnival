<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Poli;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get counts from database
        $totalPoli = Poli::count();
        $totalDokter = User::where('role', 'dokter')->count();
        $totalPasien = User::where('role', 'pasien')->count();
        $totalObat = Obat::count();

        // Get limited poli list with doctor counts
        $polis = Poli::withCount('dokters')->limit(5)->get();

        // Today's date in Indonesian format
        $tanggalHariIni = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y');

        return view('dashboard.admin', [
            'totalPoli' => $totalPoli,
            'totalDokter' => $totalDokter,
            'totalPasien' => $totalPasien,
            'totalObat' => $totalObat,
            'polis' => $polis,
            'tanggalHariIni' => $tanggalHariIni,
        ]);
    }
}
