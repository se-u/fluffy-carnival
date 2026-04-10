<x-layouts.guest title="Login">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-[420px] p-[40px]">

        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-bengkot.png') }}" class="w-[60px] h-[60px] rounded-[16px] object-cover mx-auto mb-[14px] block">
            <h1 class="text-[1.5rem] font-extrabold text-[#1e2d6b] m-0 mb-[6px]">Poliklinik</h1>
            <p class="text-[0.83rem] text-slate-400 m-0">Masuk ke akun Anda</p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-[0.83rem] flex items-center gap-2">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Email</label>
                <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-envelope text-slate-400 text-[0.82rem]"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..." class="grow bg-transparent text-slate-800 text-[0.88rem] outline-none" required>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label class="block text-[0.82rem] font-semibold text-slate-700 mb-2">Password</label>
                <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-[10px] bg-slate-50 focus-within:ring-2 focus-within:ring-[#2d4499] focus-within:border-transparent">
                    <i class="fas fa-lock text-slate-400 text-[0.82rem]"></i>
                    <input type="password" name="password" id="password_login" placeholder="Masukkan password..." class="grow bg-transparent text-slate-800 text-[0.88rem] outline-none" required>
                    <i class="fas fa-eye text-slate-400 text-[0.82rem] cursor-pointer" id="toggle_login" onclick="togglePassword('password_login', 'toggle_login')"></i>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-gradient-to-r from-[#2d4499] to-[#1e2d6b] hover:opacity-90 text-white py-3 rounded-lg font-semibold transition-opacity duration-200 mt-6">
                <i class="fas fa-right-to-bracket mr-2"></i> Login
            </button>
        </form>

        {{-- Register --}}
        <p class="text-center mt-5 text-[0.83rem] text-slate-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#2d4499] font-bold no-underline">Register</a>
        </p>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
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
