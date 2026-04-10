<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->paginate(10);
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'aktif',
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal Berhasil Ditambahkan');
    }

    public function update(Request $request, JadwalPeriksa $jadwal)
    {
        // Ensure dokter can only update their own jadwal
        if ($jadwal->id_dokter !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal Berhasil Diubah');
    }

    public function destroy(JadwalPeriksa $jadwal)
    {
        if ($jadwal->id_dokter !== Auth::id()) {
            abort(403);
        }

        $jadwal->delete();
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal Berhasil Dihapus');
    }
}
