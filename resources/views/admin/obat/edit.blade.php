<x-layouts.app title="Edit Obat">

    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-2xl">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Edit Obat</h2>

            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Obat <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kemasan <span class="text-red-500">*</span></label>
                    <input type="text" name="kemasan" value="{{ $obat->kemasan }}" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" value="{{ $obat->harga }}" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" min="0" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ $obat->stok }}" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2d4499] focus:border-transparent" min="0" required>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('obat.index') }}" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg font-medium transition-colors duration-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
