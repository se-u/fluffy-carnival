<x-layouts.app>

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Daftar Poli</h2>

        @php
            $hasActiveQueue = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                ->whereIn('status', ['pending', 'periksa'])
                ->exists();
            $latestDaftar = \App\Models\DaftarPoli::where('id_pasien', Auth::id())
                ->whereIn('status', ['pending', 'periksa'])
                ->with('jadwalPeriksa.dokter.poli')
                ->first();
        @endphp

        @if($hasActiveQueue && $latestDaftar)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                <i class="fas fa-exclamation-triangle mt-0.5"></i>
                <div>
                    <p class="font-semibold">Anda sudah memiliki antrian aktif!</p>
                    <p class="text-sm">Poli: {{ $latestDaftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                    <p class="text-sm">Dr. {{ $latestDaftar->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                    <p class="text-xl font-bold mt-2">Nomor Antrian: {{ $latestDaftar->no_antrian }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-slate-800">Jadwal Poliklinik Tersedia</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs uppercase text-slate-500 tracking-wider">
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Poli</th>
                            <th class="px-6 py-3 font-semibold">Dokter</th>
                            <th class="px-6 py-3 font-semibold">Hari</th>
                            <th class="px-6 py-3 font-semibold">Jam</th>
                            <th class="px-6 py-3 font-semibold">No. Antrian</th>
                            <th class="px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $jadwals = \App\Models\JadwalPeriksa::with(['dokter.poli'])->get();
                        @endphp
                        @forelse($jadwals as $index => $jadwal)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $jadwal->dokter->poli->nama_poli ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">dr. {{ $jadwal->dokter->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ $jadwal->no_antrian_sekarang }}</span></td>
                                <td class="px-6 py-4">
                                    @if(!$hasActiveQueue)
                                        <button class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200" onclick="showDaftarModal({{ $jadwal->id }}, '{{ $jadwal->dokter->poli->nama_poli ?? 'Poli' }}', '{{ $jadwal->dokter->nama ?? 'Dokter' }}', '{{ $jadwal->hari }}', '{{ substr($jadwal->jam_mulai, 0, 5) }}')">
                                            Daftar
                                        </button>
                                    @else
                                        <span class="text-slate-400">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-400">Tidak ada jadwal tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Pendaftaran --}}
    <dialog id="daftarModal" class="modal">
        <div class="modal-box rounded-2xl bg-white">
            <h3 class="font-bold text-lg mb-4 text-slate-800">Daftar Poli</h3>
            <form action="{{ route('pasien.daftar.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_jadwal" id="modalJadwalId">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Poli</label>
                    <input type="text" id="modalPoli" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 bg-slate-50 text-slate-600" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dokter</label>
                    <input type="text" id="modalDokter" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 bg-slate-50 text-slate-600" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Hari & Jam</label>
                    <input type="text" id="modalJadwal" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 bg-slate-50 text-slate-600" readonly>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keluhan <span class="text-red-500">*</span></label>
                    <textarea name="keluhan" rows="4" placeholder="Jelaskan keluhan Anda..." class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent resize-none" required></textarea>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" class="px-4 py-2 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200" onclick="closeModal()">Batal</button>
                    <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i> Daftar
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/50"><button>close</button></form>
    </dialog>

    <script>
        function showDaftarModal(jadwalId, poli, dokter, hari, jam) {
            document.getElementById('modalJadwalId').value = jadwalId;
            document.getElementById('modalPoli').value = poli;
            document.getElementById('modalDokter').value = dokter;
            document.getElementById('modalJadwal').value = hari + ', ' + jam;
            document.getElementById('daftarModal').showModal();
        }

        function closeModal() {
            document.getElementById('daftarModal').close();
        }
    </script>
</x-layouts.app>
