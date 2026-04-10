<?php

namespace App\Http\Controllers;

use App\Events\AntrianUpdated;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        // Get daftar poli with status pending for this dokter
        $daftarPolis = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })
        ->where('status', 'pending')
        ->with(['pasien', 'jadwalPeriksa'])
        ->orderBy('no_antrian')
        ->get();

        return view('dokter.periksa.index', compact('daftarPolis'));
    }

    public function periksa($id)
    {
        $daftar = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksas.detailPeriksas.obat'])
            ->where('id', $id)
            ->firstOrFail();

        $obats = Obat::all();

        return view('dokter.periksa.periksa', compact('daftar', 'obats'));
    }

    /**
     * Panggil pasien berikutnya - update no_antrian_sekarang and broadcast
     */
    public function panggil($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        // Find next pending patient in queue
        $nextPatient = DaftarPoli::where('id_jadwal', $id)
            ->where('status', 'pending')
            ->orderBy('no_antrian')
            ->first();

        // Update no_antrian_sekarang to next patient's number, or +1 if no one waiting
        $nextAntrian = $nextPatient ? $nextPatient->no_antrian : $jadwal->no_antrian_sekarang + 1;

        $jadwal->update(['no_antrian_sekarang' => $nextAntrian]);

        // Broadcast the update
        event(new AntrianUpdated(
            $jadwal->id,
            $nextAntrian,
            $jadwal->getRemainingQueueCount()
        ));

        return redirect()->back()->with('success', 'Pasien dipanggil: Antrian #' . $nextAntrian);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
            'biaya_periksa' => 'required|numeric|min:0',
            'obat' => 'array',
            'obat.*' => 'exists:obat,id',
        ]);

        $daftar = DaftarPoli::with('jadwalPeriksa')
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Start transaction
        DB::beginTransaction();

        try {
            // Check stock availability for all selected medicines
            if ($request->has('obat') && count($request->obat) > 0) {
                foreach ($request->obat as $obatId) {
                    $obat = Obat::find($obatId);
                    if ($obat->stok <= 0) {
                        DB::rollBack();
                        return back()->with('error', "Obat {$obat->nama_obat} stoknya habis!")->withInput();
                    }
                }

                // Also check total stock needed
                $obats = Obat::whereIn('id', $request->obat)->get();
                foreach ($obats as $obat) {
                    $countNeeded = collect($request->obat)->filter(fn($id) => $id == $obat->id)->count();
                    if ($obat->stok < $countNeeded) {
                        DB::rollBack();
                        return back()->with('error', "Obat {$obat->nama_obat} stok tidak mencukupi! Sisa stok: {$obat->stok}")->withInput();
                    }
                }
            }

            // Create periksa record
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftar->id,
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa,
            ]);

            // Create detail periksa and reduce stock
            if ($request->has('obat') && count($request->obat) > 0) {
                foreach ($request->obat as $obatId) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $obatId,
                    ]);

                    // Reduce stock
                    $obat = Obat::find($obatId);
                    $obat->decrement('stok');
                }
            }

            // Update daftar poli status to 'bayar' (waiting for payment)
            $daftar->update(['status' => 'bayar']);

            // Update jadwal's no_antrian_sekarang and call next patient
            $jadwal = $daftar->jadwalPeriksa;
            $nextAntrian = $jadwal->no_antrian_sekarang + 1;
            $jadwal->update(['no_antrian_sekarang' => $nextAntrian]);

            // Broadcast the update
            event(new AntrianUpdated(
                $jadwal->id,
                $nextAntrian,
                $jadwal->getRemainingQueueCount()
            ));

            DB::commit();

            return redirect()->route('dokter.periksa.index')
                ->with('success', 'Pemeriksaan berhasil disimpan. Tagihan: Rp ' . number_format($request->biaya_periksa, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
