<x-layouts.guest>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

            {{-- Logo & Judul --}}
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-14 h-14 rounded-xl bg-cyan-600 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3h9a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6" />
                        <path d="M6 3v18" />
                        <circle cx="9" cy="12" r="0.5" fill="currentColor" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-cyan-600">RuangTemu</h1>
                <p class="text-slate-700 mt-1">Sistem Manajemen Jadwal Rapat</p>
            </div>

            {{-- Judul Halaman --}}
            <div class="mb-6 text-center">
                <h2 class="text-lg font-semibold text-slate-800">Lupa Password</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Masukkan email Anda, kami akan mengirimkan link untuk reset password.
                </p>
            </div>

            {{-- Pesan Status / Error --}}
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form x-data="{ loading: false }" @submit="loading = true"
                  method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="M22 6l-10 7L2 6"/>
                            </svg>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                            autofocus
                            class="w-full rounded-lg border border-slate-300 pl-10 pr-4 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Kirim --}}
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-cyan-600 hover:bg-cyan-700 disabled:opacity-70 disabled:cursor-not-allowed text-white font-semibold py-2.5 rounded-lg transition flex items-center justify-center gap-2"
                >
                    <svg x-show="loading" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span x-text="loading ? 'Mengirim...' : 'Kirim Link Reset'"></span>
                </button>
            </form>

            {{-- Kembali ke Login --}}
            <p class="text-center text-sm text-slate-500 mt-6">
                <a href="{{ route('login', 'admin') }}" class="text-cyan-600 hover:text-cyan-700 hover:underline font-medium inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</x-layouts.guest>