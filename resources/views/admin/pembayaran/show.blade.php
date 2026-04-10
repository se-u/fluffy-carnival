<x-layouts.app title="Detail Pembayaran">

    <div class="p-6">
        {{-- Back button --}}
        <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="bg-white rounded-xl shadow-md border border-slate-200">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6 text-slate-800">Detail Pembayaran</h2>

                {{-- Status Badge --}}
                <div class="mb-6">
                    @if($daftar->status === 'lunas')
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-lg font-semibold bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2"></i> LUNAS
                    </span>
                    @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-lg font-semibold bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i> MENUNGGU VERIFIKASI
                    </span>
                    @endif
                </div>

                {{-- Patient Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Nama Pasien</p>
                        <p class="font-bold text-lg text-slate-800">{{ $daftar->pasien->nama ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">No. RM</p>
                        <p class="font-bold text-lg text-slate-800">{{ $daftar->pasien->no_rm ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Poli</p>
                        <p class="font-semibold text-slate-800">{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Dokter</p>
                        <p class="font-semibold text-slate-800">dr. {{ $daftar->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                    </div>
                </div>

                @if($daftar->periksas->count() > 0)
                @php
                    $periksa = $daftar->periksas->first();
                @endphp

                <hr class="my-6 border-slate-200">

                <h3 class="text-lg font-bold mb-4 text-slate-800">Detail Pemeriksaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Tanggal Periksa</p>
                        <p class="font-semibold text-slate-800">{{ $periksa->tgl_periksa->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">No. Antrian</p>
                        <p class="font-bold text-lg text-slate-800">#{{ $daftar->no_antrian }}</p>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl mb-6">
                    <p class="text-sm text-slate-500 mb-1">Catatan</p>
                    <p class="text-slate-700">{{ $periksa->catatan ?? '-' }}</p>
                </div>

                @if($periksa->detailPeriksas->count() > 0)
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-slate-800">Obat yang Diberikan</h4>
                    <div class="space-y-2">
                        @foreach($periksa->detailPeriksas as $detail)
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                            <span class="text-slate-700">{{ $detail->obat->nama_obat ?? '-' }}</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="bg-gradient-to-r from-[#1e2d6b] to-[#2d4499] p-6 rounded-xl text-white mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">Total Biaya:</span>
                        <span class="text-2xl font-bold">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Bukti Pembayaran --}}
                @if($periksa->bukti_bayar)
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-slate-800">Bukti Pembayaran</h4>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4">
                        <img src="{{ asset('storage/' . $periksa->bukti_bayar) }}" alt="Bukti Bayar" class="max-w-md rounded-lg">
                    </div>
                </div>
                @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Pasien belum mengupload bukti pembayaran</span>
                </div>
                @endif
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    @if($daftar->status === 'bayar' && $periksa && $periksa->bukti_bayar)
                    <form action="{{ route('pembayaran.konfirmasi', $daftar->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pembayaran Lunas
                        </button>
                    </form>
                    @elseif($daftar->status === 'lunas')
                    <div class="flex-1 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Pembayaran sudah lunas</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
