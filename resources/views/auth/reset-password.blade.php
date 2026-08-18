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

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="mb-4 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form x-data="{ loading: false, showPassword: false, showConfirm: false }"
                  @submit="loading = true"
                  method="POST"
                  action="{{ route('password.update') }}"
                  class="space-y-5">
                @csrf

                {{-- Token & email diperlukan untuk proses reset password bawaan Laravel --}}
                <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}">
                <input type="hidden" name="email" value="{{ old('email', request('email')) }}">

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Password Baru
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="11" width="16" height="9" rx="2" />
                                <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                            </svg>
                        </span>
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            placeholder="Masukkan password Anda"
                            required
                            autofocus
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-slate-300 pl-10 pr-11 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                            tabindex="-1"
                        >
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-3.11 4.24M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                                <path d="M1 1l22 22" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="11" width="16" height="9" rx="2" />
                                <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                            </svg>
                        </span>
                        <input
                            id="password_confirmation"
                            :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-slate-300 pl-10 pr-11 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                        >
                        <button
                            type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                            tabindex="-1"
                        >
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-3.11 4.24M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                                <path d="M1 1l22 22" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Login --}}
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-cyan-600 hover:bg-cyan-700 disabled:opacity-70 disabled:cursor-not-allowed text-white font-semibold py-2.5 rounded-lg transition flex items-center justify-center gap-2"
                >
                    <svg x-show="loading" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span x-text="loading ? 'Memproses...' : 'Login'"></span>
                </button>
            </form>
        </div>
    </div>
</x-layouts.guest>