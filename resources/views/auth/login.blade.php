<x-layouts.guest>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
            <div class="flex justify-center mb-4">
                <div class="bg-cyan-600 text-white p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
            </div>
            <h1 class="text-xl font-bold text-cyan-700 text-center">RuangTemu</h1>
            <p class="text-gray-500 text-sm text-center mb-6">
                Login sebagai {{ ucfirst($role) }}
            </p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm rounded-lg p-3 mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">

                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                       placeholder="Masukkan username Anda">

                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                       placeholder="Masukkan password Anda">

                <div class="flex items-center justify-between mb-4 text-sm">
                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2.5 rounded-lg transition">
                    Masuk
                </button>
            </form>

            @if ($role === 'user')
                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-cyan-600 hover:underline">Daftar</a>
                </p>
            @endif
        </div>
    </div>
</x-layouts.guest>