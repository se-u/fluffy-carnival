<x-layouts.app title="Data Obat">

    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Data Obat</h2>
            <div class="flex gap-3">
                <a href="{{ route('export.obat') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>
                <a href="{{ route('obat.create') }}" class="bg-[#2d4499] hover:bg-[#1e2d6b] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Obat
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs uppercase text-slate-500 tracking-wider">
                            <th class="px-6 py-3 font-semibold">No</th>
                            <th class="px-6 py-3 font-semibold">Nama Obat</th>
                            <th class="px-6 py-3 font-semibold">Kemasan</th>
                            <th class="px-6 py-3 font-semibold">Harga</th>
                            <th class="px-6 py-3 font-semibold">Stok</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($obats as $obat)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">{{ $loop->iteration + ($obats->currentPage() - 1) * $obats->perPage() }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $obat->nama_obat }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $obat->kemasan }}</td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($obat->isOutOfStock())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Habis ({{ $obat->stok }})</span>
                                @elseif($obat->isLowStock())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menipis ({{ $obat->stok }})</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">{{ $obat->stok }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($obat->isOutOfStock())
                                <span class="text-red-600 text-sm font-semibold">Habis</span>
                                @elseif($obat->isLowStock())
                                <span class="text-yellow-600 text-sm font-semibold">Menipis</span>
                                @else
                                <span class="text-green-600 text-sm font-medium">Tersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('obat.edit', $obat->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($obats->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $obats->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.app>
