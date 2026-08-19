<x-layouts.guest>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-cyan-600 text-white p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3h9a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6" />
                        <path d="M6 3v18" />
                        <circle cx="9" cy="12" r="0.5" fill="currentColor" />
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-cyan-700">RuangTemu</h1>
            <p class="text-gray-500 text-sm mt-1 mb-6">Sistem Manajemen Jadwal Ruangan Rapat</p>

            <a href="{{ route('login', 'admin') }}"
                class="block w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2.5 rounded-lg mb-3 transition">
                Masuk Sebagai Admin
            </a>
            <a href="{{ route('user.dashboard') }}"
                class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 rounded-lg transition">
                Masuk Sebagai User
            </a>
        </div>
    </div>
</x-layouts.guest>