<x-layouts.guest title="Register">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-[480px] p-[40px]">

        {{-- Logo & Title --}}
        <div class="text-center mb-7">
            <img src="{{ asset('images/logo-bengkot.png') }}" class="w-[60px] h-[60px] rounded-[16px] object-cover mx-auto mb-[14px] block">
            <h1 class="text-[1.5rem] font-extrabold text-[#1e2d6b] m-0 mb-[6px]">Poliklinik</h1>
            <p class="text-[0.83rem] text-slate-400 m-0">Buat akun baru</p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-[0.83rem] flex items-center gap-2">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-user text-slate-400 text-[0.82rem]"></i>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap..." class="grow bg-transparent text-slate-800 text-[0.88rem] outline-none" required>
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Email</label>
                <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-envelope text-slate-400 text-[0.82rem]"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..." class="grow bg-transparent text-slate-800 text-[0.88rem] outline-none" required>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Alamat</label>
                <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-map-marker-alt text-slate-400 text-[0.82rem]"></i>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat..." class="grow bg-transparent text-slate-800 text-[0.88rem] outline-none" required>
                </div>
            </div>

            {{-- No. HP & No. KTP --}}
            <div class="grid grid-cols-2 gap-[14px] mb-4">
                <div>
                    <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">No. HP</label>
                    <div class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                        <i class="fas fa-phone text-slate-400 text-[0.78rem]"></i>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="No. HP..." class="grow bg-transparent text-slate-800 text-[0.85rem] outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">No. KTP</label>
                    <div class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                        <i class="fas fa-address-card text-slate-400 text-[0.78rem]"></i>
                        <input type="number" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="No. KTP..." class="grow bg-transparent text-slate-800 text-[0.85rem] outline-none" required>
                    </div>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Password</label>
                <div class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-lock text-slate-400 text-[0.78rem]"></i>
                    <input type="password" name="password" id="password_reg" placeholder="Password..." class="grow bg-transparent text-slate-800 text-[0.85rem] outline-none" required>
                    <i class="fas fa-eye text-slate-400 text-[0.78rem] cursor-pointer" id="toggle_reg" onclick="togglePassword('password_reg', 'toggle_reg')"></i>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <div class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-lock text-slate-400 text-[0.78rem]"></i>
                    <input type="password" name="password_confirmation" id="password_confirm" placeholder="Ulangi password..." class="grow bg-transparent text-slate-800 text-[0.85rem] outline-none" required>
                    <i class="fas fa-eye text-slate-400 text-[0.78rem] cursor-pointer" id="toggle_confirm" onclick="togglePassword('password_confirm', 'toggle_confirm')"></i>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-gradient-to-r from-[#2d4499] to-[#1e2d6b] hover:opacity-90 text-white py-3 rounded-lg font-semibold transition-opacity duration-200">
                <i class="fas fa-user-plus mr-2"></i> Register
            </button>
        </form>

        <p class="text-center mt-5 text-[0.83rem] text-slate-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#2d4499] font-bold no-underline">Login</a>
        </p>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    @endpush

</x-layouts.guest>
