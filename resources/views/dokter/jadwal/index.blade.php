<x-layouts.app title="Jadwal Periksa Saya">

    <div class="p-6">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Jadwal Periksa Saya</h2>
            <div class="flex gap-3">
                <a href="{{ route('dokter.export.jadwal') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-file-excel mr-2"></i> Export Jadwal
                </a>
                <button onclick="showModal('add')" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Jadwal
                </button>
            </div>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">No</th>
                            <th class="px-6 py-3 font-semibold text-left">Hari</th>
                            <th class="px-6 py-3 font-semibold text-left">Jam</th>
                            <th class="px-6 py-3 font-semibold text-left">Status</th>
                            <th class="px-6 py-3 font-semibold text-left">No. Antrian</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($jadwals as $index => $jadwal)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $jadwal->hari }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            <td class="px-6 py-4">
                                @if($jadwal->status === 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ $jadwal->no_antrian_sekarang }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button onclick="showModal('edit', {{ $jadwal->id }}, '{{ $jadwal->hari }}', '{{ $jadwal->jam_mulai }}', '{{ $jadwal->jam_selesai }}', '{{ $jadwal->status }}')" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-pen-to-square mr-1"></i>
                                    </button>
                                    <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus jadwal ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fas fa-calendar-alt text-3xl mb-3 block"></i>
                                Belum ada jadwal pemeriksaan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($jadwals->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $jadwals->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Modal Form --}}
    <dialog id="jadwalModal" class="modal">
        <div class="modal-box rounded-2xl bg-white">
            <h3 class="font-bold text-lg mb-4 text-slate-800" id="modalTitle">Tambah Jadwal</h3>
            <form id="jadwalForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" id="hariSelect" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" id="jamMulai" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_selesai" id="jamSelesai" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" required>
                    </div>
                </div>

                <div class="mb-6" id="statusField" style="display:none;">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="status" id="statusSelect" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <button type="button" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200" onclick="document.getElementById('jadwalModal').close()">Batal</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-black/50"><button>close</button></form>
    </dialog>

    <script>
        function showModal(mode, id = null, hari = '', jamMulai = '', jamSelesai = '', status = 'aktif') {
            const modal = document.getElementById('jadwalModal');
            const form = document.getElementById('jadwalForm');
            const title = document.getElementById('modalTitle');
            const methodField = document.getElementById('formMethod');
            const statusField = document.getElementById('statusField');

            if (mode === 'add') {
                title.textContent = 'Tambah Jadwal';
                form.action = "{{ route('dokter.jadwal.store') }}";
                methodField.value = 'POST';
                statusField.style.display = 'none';
                document.getElementById('hariSelect').value = '';
                document.getElementById('jamMulai').value = '';
                document.getElementById('jamSelesai').value = '';
            } else {
                title.textContent = 'Edit Jadwal';
                form.action = '/dokter/jadwal/' + id;
                methodField.value = 'PUT';
                statusField.style.display = 'block';
                document.getElementById('hariSelect').value = hari;
                document.getElementById('jamMulai').value = jamMulai.substring(0, 5);
                document.getElementById('jamSelesai').value = jamSelesai.substring(0, 5);
                document.getElementById('statusSelect').value = status;
            }

            modal.showModal();
        }
    </script>
</x-layouts.app>
