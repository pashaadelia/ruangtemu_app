<x-layouts.app title="Dashboard - RuangTemu">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-500 mt-1">Kelola dan tinjau semua jadwal penggunaan ruangan.</p>
        </div>

        <div class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
            <input type="text"
                   placeholder="Cari ruangan atau meeting..."
                   class="pl-9 pr-4 py-2 w-72 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
        </div>
    </div>

    {{-- Jadwal Hari Ini --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Jadwal Hari Ini</h2>
            <a href="{{ route('admin.jadwal') ?? '#' }}" class="text-cyan-600 text-sm font-medium hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($jadwalHariIni as $booking)
                <x-booking-card :booking="$booking" :editable="true" />
            @empty
                <p class="text-gray-400 text-sm col-span-3">Tidak ada jadwal hari ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Riwayat --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Riwayat</h2>
            <a href="{{ route('admin.riwayat') ?? '#' }}" class="text-cyan-600 text-sm font-medium hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($riwayat as $booking)
                <x-booking-card :booking="$booking" :editable="false" />
            @empty
                <p class="text-gray-400 text-sm col-span-3">Belum ada riwayat.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>