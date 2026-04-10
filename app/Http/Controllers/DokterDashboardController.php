<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();
        $hariIni = Carbon::now('Asia/Jakarta')->locale('id')->dayName;

        // Get today's schedules for this doctor
        $jadwalsHariIni = JadwalPeriksa::where('id_dokter', $dokterId)
            ->where('hari', $hariIni)
            ->where('status', 'aktif')
            ->count();

        // Count patients who have been examined today by this doctor
        $pasienDiperiksa = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })
        ->whereIn('status', ['bayar', 'lunas'])
        ->whereDate('updated_at', Carbon::today('Asia/Jakarta'))
        ->count();

        // Count patients waiting (pending status) for this doctor
        $menunggu = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })
        ->where('status', 'pending')
        ->count();

        return view('dashboard.dokter', [
            'jadwalsHariIni' => $jadwalsHariIni,
            'pasienDiperiksa' => $pasienDiperiksa,
            'menunggu' => $menunggu,
        ]);
    }
}
