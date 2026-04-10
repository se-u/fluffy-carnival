<x-layouts.app title="Pembayaran">

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Pembayaran</h2>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @php
            $pendingPayments = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                ->where('status', 'bayar')
                ->with(['jadwalPeriksa.dokter.poli', 'periksas'])
                ->get();

            $completedPayments = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                ->where('status', 'lunas')
                ->with(['jadwalPeriksa.dokter.poli', 'periksas'])
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();
        @endphp

        {{-- Tagihan Menunggu --}}
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-700 mb-4">Tagihan Menunggu</h3>

            @if($pendingPayments->count() > 0)
            <div class="space-y-4">
                @foreach($pendingPayments as $payment)
                @php
                    $periksa = $payment->periksas->first();
                    $total = $periksa ? $periksa->biaya_periksa : 0;
                    $hasBukti = $periksa && $periksa->bukti_bayar;
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">{{ $payment->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</h3>
                                <p class="text-sm text-slate-500">dr. {{ $payment->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                                <p class="text-sm text-slate-500">{{ $payment->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-[#2d4499]">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                @if($hasBukti)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Belum Bayar</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t mt-4 pt-4">
                            @if($hasBukti)
                            <div class="flex items-center gap-2 text-yellow-600">
                                <i class="fas fa-clock"></i>
                                <span>Bukti pembayaran sudah diupload. Menunggu verifikasi admin.</span>
                            </div>
                            @else
                            <h4 class="font-semibold mb-3 text-slate-700">Upload Bukti Pembayaran</h4>
                            <form action="{{ route('pasien.pembayaran.upload', $payment->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="file" name="bukti_bayar" class="file-input file-input-bordered flex-1" accept="image/*" required>
                                    <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        <i class="fas fa-upload mr-2"></i> Upload
                                    </button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center">
                <i class="fas fa-check-circle text-4xl mb-3 text-emerald-500"></i>
                <p class="text-slate-500">Tidak ada tagihan yang perlu dibayar</p>
            </div>
            @endif
        </div>

        {{-- Riwayat Pembayaran --}}
        @if($completedPayments->count() > 0)
        <div>
            <h3 class="text-lg font-semibold text-slate-700 mb-4">Riwayat Pembayaran</h3>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 font-semibold text-left">Tanggal</th>
                                <th class="px-6 py-3 font-semibold text-left">Poli</th>
                                <th class="px-6 py-3 font-semibold text-left">Dokter</th>
                                <th class="px-6 py-3 font-semibold text-right">Total</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($completedPayments as $payment)
                            @php
                                $periksa = $payment->periksas->first();
                                $total = $periksa ? $periksa->biaya_periksa : 0;
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-slate-600">{{ $payment->updated_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $payment->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">dr. {{ $payment->jadwalPeriksa->dokter->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-800">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Lunas</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
