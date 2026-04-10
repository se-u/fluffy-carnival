<x-layouts.app title="Tambah Poli">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('poli.index') }}" class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors duration-200">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Tambah Poli</h2>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="p-7">

            <form action="{{ route('poli.store') }}" method="POST">
                @csrf

                {{-- Nama Poli --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Poli <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_poli" value="{{ old('nama_poli') }}" placeholder="Masukkan nama poli..." class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('nama_poli') border-red-500 @enderror" required>
                    @error('nama_poli')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                    <textarea name="keterangan" rows="4" placeholder="Masukkan keterangan poli..." class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent resize-none @error('keterangan') border-red-500 @enderror" required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold transition-colors duration-200">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('poli.index') }}" class="flex items-center gap-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg text-sm font-semibold transition-colors duration-200">Batal</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
