<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik - Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2d4499',
                        secondary: '#1e2d6b',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 font-sans">

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-[#1e2d6b] to-[#2d4499] text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-bengkot.png') }}" class="w-10 h-10 rounded-xl object-cover">
                    <span class="text-xl font-bold">Poliklinik</span>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="#fitur" class="hover:text-white/80 transition-colors">Fitur</a>
                    <a href="#jadwal" class="hover:text-white/80 transition-colors">Jadwal</a>
                    <a href="#kontak" class="hover:text-white/80 transition-colors">Kontak</a>
                    <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg font-medium transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-[#2d4499] hover:bg-white/90 px-4 py-2 rounded-lg font-semibold transition-colors">Register</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-[#1e2d6b] to-[#2d4499] text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
                        Layanan Kesehatan Terintegrasi & Mudah
                    </h1>
                    <p class="text-lg text-white/80 mb-8">
                        Daftar poli, lihat jadwal dokter, dan kelola pemeriksaan kesehatan Anda dalam satu platform digital yang mudah digunakan.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('register') }}" class="bg-white text-[#2d4499] px-6 py-3 rounded-lg font-semibold hover:bg-white/90 transition-colors inline-flex items-center gap-2">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                        <a href="#jadwal" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i> Lihat Jadwal
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="bg-white/10 backdrop-blur rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white/20 rounded-xl p-4 text-center">
                                <i class="fas fa-hospital text-3xl mb-2"></i>
                                <p class="font-semibold">Multiple Poli</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-4 text-center">
                                <i class="fas fa-user-md text-3xl mb-2"></i>
                                <p class="font-semibold">Dokter Berpengalaman</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-4 text-center">
                                <i class="fas fa-clock text-3xl mb-2"></i>
                                <p class="font-semibold">Antrian Real-Time</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-4 text-center">
                                <i class="fas fa-mobile-alt text-3xl mb-2"></i>
                                <p class="font-semibold">Akses Mudah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur Section --}}
    <section id="fitur" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Fitur Unggulan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Platform kami menyediakan berbagai fitur untuk memudahkan Anda dalam mengakses layanan kesehatan</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-slate-50 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Pendaftaran Online</h3>
                    <p class="text-slate-500">Daftar poli tanpa antre. Pilih jadwal dokter dan poly yang tersedia dengan mudah.</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                        <i class="fas fa-bell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Notifikasi Real-Time</h3>
                    <p class="text-slate-500">Antrian diperbarui secara otomatis. Anda tahu kapan giliran Anda mendekat.</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                        <i class="fas fa-history text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Riwayat Medis</h3>
                    <p class="text-slate-500">Lihat riwayat pemeriksaan dan hasil konsultasi dokter kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Jadwal Section --}}
    <section id="jadwal" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Jadwal Praktik Dokter</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Berikut adalah jadwal praktik dokter di poliklinik kami</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr class="text-left text-xs uppercase text-slate-500 tracking-wider">
                                <th class="px-6 py-4 font-semibold">Poli</th>
                                <th class="px-6 py-4 font-semibold">Dokter</th>
                                <th class="px-6 py-4 font-semibold">Hari</th>
                                <th class="px-6 py-4 font-semibold">Jam</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $jadwals = \App\Models\JadwalPeriksa::with(['dokter.poli'])->where('status', 'aktif')->get();
                            @endphp
                            @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $jadwal->dokter->poli->nama_poli ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">dr. {{ $jadwal->dokter->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada jadwal tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak Section --}}
    <section id="kontak" class="py-16 bg-[#1e2d6b] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-bengkot.png') }}" class="w-10 h-10 rounded-xl object-cover">
                        <span class="text-xl font-bold">Poliklinik</span>
                    </div>
                    <p class="text-white/70">Layanan kesehatan terpercaya untuk keluarga Anda dengan dokter berpengalaman dan fasilitas lengkap.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Kontak</h3>
                    <div class="space-y-3 text-white/70">
                        <p class="flex items-center gap-2"><i class="fas fa-map-marker-alt w-5"></i> Jl. Kesehatan No. 123, Jakarta</p>
                        <p class="flex items-center gap-2"><i class="fas fa-phone w-5"></i> (021) 1234-5678</p>
                        <p class="flex items-center gap-2"><i class="fas fa-envelope w-5"></i> info@poliklinik.com</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Jam Operasional</h3>
                    <div class="space-y-3 text-white/70">
                        <p class="flex items-center gap-2"><i class="fas fa-clock w-5"></i> Senin - Jumat: 08:00 - 16:00</p>
                        <p class="flex items-center gap-2"><i class="fas fa-clock w-5"></i> Sabtu: 08:00 - 12:00</p>
                        <p class="flex items-center gap-2"><i class="fas fa-clock w-5"></i> Minggu: Tutup</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#1e2d6b] text-white/50 py-4 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2026 Poliklinik. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
