<x-layouts.app title="Verifikasi Pembayaran">

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Verifikasi Pembayaran</h2>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">No</th>
                            <th class="px-6 py-3 font-semibold text-left">Pasien</th>
                            <th class="px-6 py-3 font-semibold text-left">Poli</th>
                            <th class="px-6 py-3 font-semibold text-left">Dokter</th>
                            <th class="px-6 py-3 font-semibold text-right">Total Biaya</th>
                            <th class="px-6 py-3 font-semibold text-left">Bukti</th>
                            <th class="px-6 py-3 font-semibold text-left">Status</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $payments = \App\Models\DaftarPoli::where(function($q) {
                                $q->where('status', 'bayar')->orWhere('status', 'lunas');
                            })
                            ->whereHas('periksas')
                            ->with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksas'])
                            ->orderByRaw("FIELD(status, 'bayar', 'lunas')")
                            ->orderBy('updated_at', 'desc')
                            ->paginate(10);
                        @endphp
                        @forelse($payments as $index => $payment)
                        @php
                            $periksa = $payment->periksas->first();
                            $hasBukti = $periksa && $periksa->bukti_bayar;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $payment->pasien->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">dr. {{ $payment->jadwalPeriksa->dokter->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-800">Rp {{ number_format($periksa->biaya_periksa ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($hasBukti)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i> Ada</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800"><i class="fas fa-times mr-1"></i> Belum</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'lunas')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Lunas</span>
                                @elseif($hasBukti)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menunggu</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pembayaran.show', $payment->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-400">
                                <i class="fas fa-receipt text-3xl mb-3 block"></i>
                                Tidak ada data pembayaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.app>
