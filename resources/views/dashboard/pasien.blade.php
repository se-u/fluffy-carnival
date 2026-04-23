<x-layouts.app>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6 text-slate-800">Dashboard Pasien</h1>

        {{-- Banner Antrian Aktif --}}
        @php
            $activeQueue = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                ->whereIn('status', ['pending', 'periksa'])
                ->with(['jadwalPeriksa.dokter.poli', 'jadwalPeriksa'])
                ->first();
        @endphp

        @if($activeQueue)
        {{-- Banner dengan info antrian aktif --}}
        <div class="bg-gradient-to-r from-[#1e2d6b] to-[#2d4499] rounded-2xl p-6 mb-6 text-white shadow-lg" data-jadwal-id="{{ $activeQueue->id_jadwal }}">
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Kiri: Info --}}
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                        <h2 class="text-xl font-bold">ANTRIAN AKTIF ANDA</h2>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hospital w-5"></i>
                            <span class="text-lg">{{ $activeQueue->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-md w-5"></i>
                            <span>dr. {{ $activeQueue->jadwalPeriksa->dokter->nama ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-day w-5"></i>
                            <span>{{ $activeQueue->jadwalPeriksa->hari }}, {{ substr($activeQueue->jadwalPeriksa->jam_mulai, 0, 5) }} - {{ substr($activeQueue->jadwalPeriksa->jam_selesai, 0, 5) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Nomor Antrian --}}
                <div class="flex gap-4">
                    {{-- Card Nomor Antrian User --}}
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[120px]">
                        <p class="text-sm text-white/70 mb-1">Nomor Antrian</p>
                        <p class="text-4xl font-bold" id="user-antrian">{{ $activeQueue->no_antrian }}</p>
                    </div>

                    {{-- Card Nomor Sedang Dilayani --}}
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[120px]">
                        <p class="text-sm text-white/70 mb-1">Sedang Dilayani</p>
                        <p class="text-4xl font-bold" id="serve-antrian">{{ $activeQueue->jadwalPeriksa->no_antrian_sekarang ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        {{-- Banner kosong --}}
        <div class="bg-white rounded-2xl p-8 mb-6 text-center border border-dashed border-slate-300">
            <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
            <p class="text-slate-500">Belum ada antrian aktif</p>
            <p class="text-sm text-slate-400 mt-1">Silakan daftar poli untuk memulai pemeriksaan</p>
        </div>
        @endif

        {{-- Tabel Jadwal Poliklinik --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Jadwal Poliklinik</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">No</th>
                            <th class="px-6 py-3 font-semibold text-left">Poli</th>
                            <th class="px-6 py-3 font-semibold text-left">Dokter</th>
                            <th class="px-6 py-3 font-semibold text-left">Hari</th>
                            <th class="px-6 py-3 font-semibold text-left">Jam</th>
                            <th class="px-6 py-3 font-semibold text-center">No. Antrian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $jadwals = \App\Models\JadwalPeriksa::with(['dokter.poli'])->get();
                        @endphp
                        @forelse($jadwals as $index => $jadwal)
                        <tr data-jadwal-id="{{ $jadwal->id }}" class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $jadwal->dokter->poli->nama_poli ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">dr. {{ $jadwal->dokter->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $jadwal->hari }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 jadwal-antrian" data-antrian="{{ $jadwal->no_antrian_sekarang }}">
                                    {{ $jadwal->no_antrian_sekarang }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fas fa-calendar-times text-3xl mb-2 block"></i>
                                Tidak ada jadwal tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Pasien --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Pasien</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-slate-500">Nama</p>
                    <p class="font-semibold text-slate-800">{{ Auth::user()->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">No. RM</p>
                    <p class="font-semibold text-slate-800">{{ Auth::user()->no_rm ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">No. HP</p>
                    <p class="font-semibold text-slate-800">{{ Auth::user()->no_hp ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @php
    $allJadwalIds = $jadwals->pluck('id')->toArray();
    @endphp

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jadwalIds = @json($allJadwalIds);
            const userAntrian = parseInt(document.getElementById('user-antrian')?.textContent) || null;
            let popupShown = false;

            if (window.socketClient) {
                jadwalIds.forEach(function(jadwalId) {
                    window.socketClient.join('antrian.' + jadwalId);
                });

                window.socketClient.on('AntrianUpdated', function(event) {
                    console.log('[SocketIO] Received AntrianUpdated:', event);
                    const jadwalId = event.jadwalId;

                    // Update table row
                    const row = document.querySelector('tr[data-jadwal-id="' + jadwalId + '"]');
                    if (row) {
                        const antrianBadge = row.querySelector('.jadwal-antrian');
                        if (antrianBadge) {
                            antrianBadge.textContent = event.noAntrianSekarang;
                        }
                    }

                    // Update banner antrian aktif
                    const banner = document.querySelector('[data-jadwal-id="' + jadwalId + '"]');
                    if (banner) {
                        const serveEl = document.getElementById('serve-antrian');
                        if (serveEl) {
                            serveEl.textContent = event.noAntrianSekarang;
                        }

                        // Check if it's user's turn
                        if (userAntrian && event.noAntrianSekarang === userAntrian && !popupShown) {
                            popupShown = true;
                            showGiliranPopup();
                        }
                    }
                });
            }

            function showGiliranPopup() {
                const popup = document.createElement('div');
                popup.id = 'giliran-popup';
                popup.innerHTML = `
                    <div style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:9999;display:flex;align-items:center;justify-content:center;">
                        <div style="background:white;border-radius:16px;padding:32px;text-align:center;max-width:400px;margin:20px;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:popup-appear 0.3s ease-out">
                            <div style="font-size:64px;margin-bottom:16px;">🔔</div>
                            <h2 style="font-size:24px;font-weight:bold;color:#1e2d6b;margin-bottom:8px;">Sekarang Giliran Anda!</h2>
                            <p style="color:#666;margin-bottom:24px;">Silakan menuju ruang pemeriksaan</p>
                            <p style="font-size:18px;color:#1e2d6b;margin-bottom:24px;">Nomor Antrian: <strong style="font-size:32px;color:#2d4499;">${userAntrian}</strong></p>
                            <button onclick="this.closest('#giliran-popup').remove()" style="background:#2d4499;color:white;border:none;padding:12px 32px;border-radius:8px;font-size:16px;cursor:pointer;font-weight:600;">OK</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(popup);

                // Auto-dismiss after 10 seconds
                setTimeout(() => {
                    if (document.getElementById('giliran-popup')) {
                        popup.remove();
                    }
                }, 10000);
            }
        });
    </script>
    <style>
        @keyframes popup-appear {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
    @endpush
</x-layouts.app>
