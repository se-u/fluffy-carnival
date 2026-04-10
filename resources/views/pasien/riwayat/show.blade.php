<x-layouts.app>

    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Detail Pemeriksaan</h2>

            @php
                $daftar = \App\Models\DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'periksas.detailPeriksas.obat'])
                    ->where('id', $id)
                    ->where('id_pasien', Auth::id())
                    ->firstOrFail();
                $periksa = $daftar->periksas->first();
            @endphp

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Poli</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Dokter</p>
                    <p class="font-semibold text-slate-800">dr. {{ $daftar->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Tanggal Pendaftaran</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">No. Antrian</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->no_antrian }}</p>
                </div>
            </div>

            @if($periksa)
                <hr class="my-6 border-slate-200">

                <h3 class="text-lg font-semibold mb-4 text-slate-800">Hasil Pemeriksaan</h3>
                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-1">Tanggal Periksa</p>
                    <p class="font-semibold text-slate-800">{{ $periksa->tgl_periksa->format('d/m/Y') }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-1">Keluhan</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->keluhan }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-1">Catatan Dokter</p>
                    <p class="font-semibold text-slate-800">{{ $periksa->catatan }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-2">Obat yang Diberikan</p>
                    <ul class="list-disc list-inside text-slate-700">
                        @forelse($periksa->detailPeriksas as $detail)
                            <li>{{ $detail->obat->nama_obat ?? '-' }} ({{ $detail->obat->kemasan ?? '-' }})</li>
                        @empty
                            <li>Tidak ada obat</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-slate-100 p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-slate-800">Total Biaya:</span>
                        <span class="text-xl font-bold text-[#2d4499]">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm text-slate-500 mb-2">Status Pembayaran</p>
                    @if($daftar->status === 'lunas')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">LUNAS</span>
                    @elseif($daftar->status === 'bayar')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Menunggu Konfirmasi</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">{{ strtoupper($daftar->status) }}</span>
                    @endif
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Pemeriksaan belum dilakukan</span>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('pasien.riwayat.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
