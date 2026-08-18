<x-layouts.app title="Jadwal Hari Ini - RuangTemu">
    <div x-data="{ search: '{{ request('search') }}', ruangan: '{{ request('ruangan') }}' }">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Jadwal Hari Ini</h1>
            </div>

            <a href="#"
               class="flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan
            </a>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('admin.jadwal') }}" class="flex gap-3 mb-6">
            <div class="relative flex-1">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
                <input type="text" name="search" x-model="search"
                       placeholder="Cari ruangan atau meeting..."
                       class="pl-9 pr-4 py-2.5 w-full border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>

            <select name="ruangan" x-model="ruangan" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg text-sm px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white">
                <option value="">Ruangan</option>
                @foreach ($ruangans as $r)
                    <option value="{{ $r->id }}" @selected(request('ruangan') == $r->id)>
                        {{ $r->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Grid Jadwal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($jadwal as $booking)
                <x-booking-card :booking="$booking" :editable="true" />
            @empty
                <p class="text-gray-400 text-sm col-span-3">Tidak ada jadwal yang ditemukan.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>