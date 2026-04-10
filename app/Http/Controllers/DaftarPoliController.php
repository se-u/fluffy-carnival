<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarPoliController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Check if user has active queue
        $activeQueue = DaftarPoli::where('id_pasien', $userId)
            ->whereIn('status', ['pending', 'periksa'])
            ->with(['jadwalPeriksa.dokter.poli'])
            ->first();

        // Get all schedules with doctor info
        $jadwals = JadwalPeriksa::with(['dokter.poli'])->get();

        return view('pasien.daftar.index', compact('activeQueue', 'jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:500',
        ]);

        $userId = Auth::id();

        // Check if patient already has active queue
        $hasActive = DaftarPoli::where('id_pasien', $userId)
            ->whereIn('status', ['pending', 'periksa'])
            ->exists();

        if ($hasActive) {
            return back()->with('error', 'Anda sudah memiliki antrian aktif. Tidak dapat mendaftar ke poli lain.');
        }

        // Get the schedule to determine next queue number
        $jadwal = JadwalPeriksa::findOrFail($request->id_jadwal);

        // Get the latest queue number for this schedule
        $latestQueue = DaftarPoli::where('id_jadwal', $request->id_jadwal)
            ->max('no_antrian');

        $nextQueue = $latestQueue + 1;

        // Create the registration
        $daftar = DaftarPoli::create([
            'id_pasien' => $userId,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $nextQueue,
            'status' => 'pending',
        ]);

        return redirect()->route('pasien.dashboard')->with('success', "Berhasil mendaftar. Nomor antrian Anda adalah {$nextQueue}");
    }
}
