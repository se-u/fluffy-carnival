<x-layouts.app>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6 text-slate-800">Dashboard Dokter</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Jadwal Hari Ini</p>
                        <p class="text-2xl font-bold text-[#2d4499]">{{ $jadwalsHariIni }}</p>
                        <p class="text-xs text-slate-400 mt-1">Jadwal aktif hari ini</p>
                    </div>
                    <div class="text-[#2d4499]">
                        <i class="fas fa-calendar-alt text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Pasien Dieniksa</p>
                        <p class="text-2xl font-bold text-emerald-500">{{ $pasienDiperiksa }}</p>
                        <p class="text-xs text-slate-400 mt-1">Sudah diperiksa hari ini</p>
                    </div>
                    <div class="text-emerald-500">
                        <i class="fas fa-clipboard-check text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Menunggu</p>
                        <p class="text-2xl font-bold text-amber-500">{{ $menunggu }}</p>
                        <p class="text-xs text-slate-400 mt-1">Pasien dalam antrian</p>
                    </div>
                    <div class="text-amber-500">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Selamat Datang, Dr. {{ Auth::user()->nama }}</h2>
            <p class="text-slate-600">
                Poli: <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ Auth::user()->poli->nama_poli ?? 'Belum ditentukan' }}</span>
            </p>
        </div>
    </div>
</x-layouts.app>
