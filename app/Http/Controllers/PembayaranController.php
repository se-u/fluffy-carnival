<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function indexPasien()
    {
        $userId = Auth::id();

        // Get all daftar poli with status bayar or lunas for this patient
        $payments = DaftarPoli::where('id_pasien', $userId)
            ->whereIn('status', ['bayar', 'lunas'])
            ->with(['jadwalPeriksa.dokter.poli', 'periksas'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('pasien.pembayaran.index', compact('payments'));
    }

    public function indexAdmin()
    {
        // Get all daftar poli with status bayar (waiting for confirmation)
        $payments = DaftarPoli::where('status', 'bayar')
            ->orWhere('status', 'lunas')
            ->whereHas('periksas')
            ->with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksas'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.pembayaran.index', compact('payments'));
    }

    public function showAdmin($id)
    {
        $daftar = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksas.detailPeriksas.obat'])
            ->where('id', $id)
            ->firstOrFail();

        return view('admin.pembayaran.show', compact('daftar'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
        ]);

        $daftar = DaftarPoli::where('id', $id)
            ->where('id_pasien', Auth::id())
            ->where('status', 'bayar')
            ->firstOrFail();

        $file = $request->file('bukti_bayar');
        $path = $file->store('bukti_bayar', 'public');

        $periksa = $daftar->periksas->first();
        if ($periksa) {
            $periksa->update(['bukti_bayar' => $path]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function konfirmasi($id)
    {
        $daftar = DaftarPoli::where('id', $id)
            ->where('status', 'bayar')
            ->firstOrFail();

        $daftar->update(['status' => 'lunas']);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi. Status sekarang LUNAS.');
    }
}
