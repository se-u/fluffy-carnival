<x-layouts.app title="Pemeriksaan Pasien">

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Pemeriksaan Pasien</h2>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- Jadwal Info with Panggil Button --}}
        @php
            $dokterJadwals = \App\Models\JadwalPeriksa::where('id_dokter', Auth::id())->get();
        @endphp

        @if($dokterJadwals->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
            <div class="p-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-700">Jadwal Saya</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($dokterJadwals as $jadwal)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $jadwal->hari }}, {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                        <p class="text-sm text-slate-500">
                            Sedang Melayani: <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ $jadwal->no_antrian_sekarang }}</span>
                            | Sisa Antrian: <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">{{ $jadwal->getRemainingQueueCount() }}</span>
                        </p>
                    </div>
                    @if($jadwal->getRemainingQueueCount() > 0)
                    <form action="{{ route('dokter.periksa.panggil', $jadwal->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-bell mr-2"></i> Panggil Pasien
                        </button>
                    </form>
                    @else
                    <span class="text-slate-400 italic">Tidak ada antrian</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Patient Queue Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="p-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-700">Daftar Pasien Menunggu</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">No</th>
                            <th class="px-6 py-3 font-semibold text-left">No. Antrian</th>
                            <th class="px-6 py-3 font-semibold text-left">Nama Pasien</th>
                            <th class="px-6 py-3 font-semibold text-left">Poli</th>
                            <th class="px-6 py-3 font-semibold text-left">Keluhan</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($daftarPolis as $index => $daftar)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($daftar->no_antrian == $daftar->jadwalPeriksa->no_antrian_sekarang)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold bg-green-100 text-green-800">#{{ $daftar->no_antrian }}</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold bg-blue-100 text-blue-800">#{{ $daftar->no_antrian }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $daftar->pasien->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $daftar->keluhan }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('dokter.periksa.periksa', $daftar->id) }}" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-stethoscope mr-2"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fas fa-user-check text-3xl mb-3 block"></i>
                                Tidak ada pasien yang menunggu
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
