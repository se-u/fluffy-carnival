<x-layouts.app>
    <div class="p-6">
        {{-- ================= HEADER ================= --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-1">
                Selamat datang, {{ Auth::user()->nama }}
            </h1>
            <p class="text-slate-500 text-sm">
                <i class="fas fa-calendar-day mr-1"></i>
                {{ $tanggalHariIni }}
            </p>
        </div>

        {{-- ================= STATS CARDS ROW ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- Total Poli --}}
            <div class="bg-white rounded-xl shadow-sm border-t-4 border-[#2d4499] p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total Poli</p>
                        <p class="text-2xl font-bold text-[#2d4499]">{{ $totalPoli }}</p>
                        <p class="text-xs text-slate-400 mt-1">Poliklinik tersedia</p>
                    </div>
                    <div class="text-[#2d4499]">
                        <i class="fas fa-hospital text-3xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Dokter --}}
            <div class="bg-white rounded-xl shadow-sm border-t-4 border-emerald-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total Dokter</p>
                        <p class="text-2xl font-bold text-emerald-500">{{ $totalDokter }}</p>
                        <p class="text-xs text-slate-400 mt-1">Dokter aktif</p>
                    </div>
                    <div class="text-emerald-500">
                        <i class="fas fa-user-md text-3xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Pasien --}}
            <div class="bg-white rounded-xl shadow-sm border-t-4 border-cyan-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total Pasien</p>
                        <p class="text-2xl font-bold text-cyan-500">{{ $totalPasien }}</p>
                        <p class="text-xs text-slate-400 mt-1">Pasien terdaftar</p>
                    </div>
                    <div class="text-cyan-500">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Obat --}}
            <div class="bg-white rounded-xl shadow-sm border-t-4 border-amber-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total Obat</p>
                        <p class="text-2xl font-bold text-amber-500">{{ $totalObat }}</p>
                        <p class="text-xs text-slate-400 mt-1">Obat tersedia</p>
                    </div>
                    <div class="text-amber-500">
                        <i class="fas fa-pills text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TWO COLUMN LAYOUT ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ========== LEFT: Daftar Poli Table ========== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Poli</h3>
                    <a href="{{ route('poli.index') }}" class="text-sm text-[#2d4499] hover:text-[#1e2d6b] font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 font-semibold text-left">Nama Poli</th>
                                <th class="px-6 py-3 font-semibold text-left">Keterangan</th>
                                <th class="px-6 py-3 font-semibold text-center">Dokter</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($polis as $poli)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $poli->nama_poli }}</td>
                                <td class="px-6 py-4 text-slate-500 text-sm">{{ $poli->keterangan }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $poli->dokters_count }} dokter
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-slate-400">
                                    <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                    Belum ada data poli
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ========== RIGHT: Quick Access ========== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Akses Cepat</h3>
                </div>
                <div class="grid grid-cols-2 gap-4 p-6">
                    <a href="{{ route('poli.create') }}" class="flex flex-col items-center justify-center p-5 rounded-xl bg-gradient-to-br from-[#2d4499] to-[#1e2d6b] text-white hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <i class="fas fa-hospital text-2xl mb-2"></i>
                        <span class="font-semibold text-sm">Tambah Poli</span>
                        <span class="text-xs text-white/70">daftarkan poli baru</span>
                    </a>

                    <a href="{{ route('dokter.index') }}" class="flex flex-col items-center justify-center p-5 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <i class="fas fa-user-md text-2xl mb-2"></i>
                        <span class="font-semibold text-sm">Tambah Dokter</span>
                        <span class="text-xs text-white/70">tambahkan dokter baru</span>
                    </a>

                    <a href="{{ route('pasien.index') }}" class="flex flex-col items-center justify-center p-5 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 text-white hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <i class="fas fa-user-plus text-2xl mb-2"></i>
                        <span class="font-semibold text-sm">Tambah Pasien</span>
                        <span class="text-xs text-white/70">tambahkan pasien baru</span>
                    </a>

                    <a href="{{ route('obat.create') }}" class="flex flex-col items-center justify-center p-5 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <i class="fas fa-pills text-2xl mb-2"></i>
                        <span class="font-semibold text-sm">Tambah Obat</span>
                        <span class="text-xs text-white/70">tambahkan obat baru</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
