<x-layouts.app title="Edit Pasien">

    <div class="p-6">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('pasien.index') }}" class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors duration-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Edit Pasien</h2>
        </div>

        {{-- Alert Error --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 max-w-2xl">
            <div class="p-7">
                <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $pasien->nama) }}" placeholder="Masukkan nama lengkap" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $pasien->email) }}" placeholder="Masukkan email" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('email') border-red-500 @enderror" required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password (optional) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-slate-400">(opsional)</span></label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('password') border-red-500 @enderror">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-slate-400 text-xs mt-1">Minimal 6 karakter</p>
                    </div>

                    {{-- No. KTP --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. KTP <span class="text-red-500">*</span></label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp', $pasien->no_ktp) }}" placeholder="Masukkan nomor KTP" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('no_ktp') border-red-500 @enderror" required>
                        @error('no_ktp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                        <input type="text" name="alamat" value="{{ old('alamat', $pasien->alamat) }}" placeholder="Masukkan alamat" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('alamat') border-red-500 @enderror" required>
                        @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. HP --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" placeholder="Masukkan nomor HP" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent @error('no_hp') border-red-500 @enderror" required>
                        @error('no_hp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                        <a href="{{ route('pasien.index') }}" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
