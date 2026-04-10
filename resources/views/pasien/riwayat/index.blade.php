<x-layouts.app>

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Riwayat Pendaftaran</h2>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs uppercase text-slate-500 tracking-wider">
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                            <th class="px-6 py-3 font-semibold">Poli</th>
                            <th class="px-6 py-3 font-semibold">Dokter</th>
                            <th class="px-6 py-3 font-semibold">No. Antrian</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $daftars = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                                ->with(['jadwalPeriksa.dokter.poli', 'periksas'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
                        @endphp
                        @forelse($daftars as $index => $daftar)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $daftar->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">dr. {{ $daftar->jadwalPeriksa->dokter->nama ?? '-' }}</td>
                                <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ $daftar->no_antrian }}</span></td>
                                <td class="px-6 py-4">
                                    @switch($daftar->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @break
                                        @case('periksa')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Sedang Diperiksa</span>
                                            @break
                                        @case('selesai')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Selesai</span>
                                            @break
                                        @case('bayar')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menunggu Bayar</span>
                                            @break
                                        @case('lunas')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Lunas</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    @if($daftar->periksas->count() > 0)
                                        <a href="{{ route('pasien.riwayat.show', $daftar->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400">Belum ada riwayat pendaftaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($daftars->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $daftars->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.app>
