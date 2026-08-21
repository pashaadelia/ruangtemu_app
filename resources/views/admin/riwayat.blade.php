<x-layouts.app :title="'Riwayat - RuangTemu'">
    <div x-data="{ search: '{{ $search }}', ruangan: '{{ $ruanganFilter }}' }">

        <div class="flex items-start justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Riwayat</h1>
                <p class="text-gray-500 mt-1">Kelola dan tinjau semua jadwal penggunaan ruangan.</p>
            </div>

            <form action="{{ route('admin.riwayat') }}" method="GET" class="flex gap-3 shrink-0">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="search" x-model="search"
                           x-on:input.debounce.500ms="$el.form.submit()"
                           placeholder="Cari ruangan atau meeting..."
                           class="w-72 pl-9 pr-4 py-2.5 text-sm rounded-lg border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent">
                </div>

                <select name="ruangan" x-model="ruangan" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-lg text-sm px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-600 bg-white">
                    <option value="">Ruangan</option>
                    @foreach ($ruangans as $r)
                        <option value="{{ $r->id }}" @selected($ruanganFilter == $r->id)>
                            {{ $r->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if ($riwayats->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($riwayats as $riwayat)
                    <x-booking-card :booking="$riwayat" :editable="false" />
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center text-center py-24 bg-white border border-dashed border-gray-200 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="text-gray-500 font-medium">Belum ada data riwayat</p>
                <p class="text-sm text-gray-400 mt-1">Riwayat penggunaan ruangan akan muncul di sini.</p>
            </div>
        @endif
    </div>
</x-layouts.app>