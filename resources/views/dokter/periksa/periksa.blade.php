<x-layouts.app title="Pemeriksaan Pasien">

    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Pemeriksaan Pasien</h2>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Nama Pasien</p>
                    <p class="font-semibold text-lg text-slate-800">{{ $daftar->pasien->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">No. Antrian</p>
                    <p class="font-semibold text-lg">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">{{ $daftar->no_antrian }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Poli</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Keluhan</p>
                    <p class="font-semibold text-slate-800">{{ $daftar->keluhan }}</p>
                </div>
            </div>

            <hr class="my-6 border-slate-200">

            <form action="{{ route('dokter.periksa.store', $daftar->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Pemeriksaan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="4" placeholder="Masukkan catatan hasil pemeriksaan..." class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent resize-none" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Biaya Periksa <span class="text-red-500">*</span></label>
                    <input type="number" name="biaya_periksa" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" placeholder="0" min="0" value="150000" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Obat yang Diberikan</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @forelse($obats as $obat)
                            <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors duration-150 @if($obat->stok <= 0) opacity-50 cursor-not-allowed @endif">
                                <input type="checkbox" name="obat[]" value="{{ $obat->id }}" class="mt-1 w-4 h-4 text-[#2d4499] rounded border-slate-300 focus:ring-[#2d4499]" @if($obat->stok <= 0) disabled @endif>
                                <div class="flex-1">
                                    <p class="font-semibold text-sm text-slate-800">{{ $obat->nama_obat }}</p>
                                    <p class="text-xs text-slate-500">{{ $obat->kemasan }}</p>
                                    <p class="text-xs mt-1">
                                        @if($obat->stok <= 0)
                                            <span class="text-red-600 font-medium">Stok habis</span>
                                        @elseif($obat->isLowStock())
                                            <span class="text-yellow-600 font-medium">Sisa {{ $obat->stok }}</span>
                                        @else
                                            <span class="text-green-600 font-medium">Stok: {{ $obat->stok }}</span>
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                            </label>
                        @empty
                            <p class="col-span-full text-center text-slate-500 py-4">Tidak ada obat tersedia</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('dokter.periksa.index') }}" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
