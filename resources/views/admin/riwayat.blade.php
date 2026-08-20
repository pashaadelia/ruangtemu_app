<x-layouts.app :title="'Riwayat - RuangTemu'">
    <div x-data="{ search: '{{ $search }}' }">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Riwayat</h1>
                <p class="text-gray-500 mt-1">Kelola dan tinjau semua jadwal penggunaan ruangan.</p>
            </div>

            <form action="{{ route('admin.riwayat') }}" method="GET" class="shrink-0">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input
                        type="text"
                        name="search"
                        x-model="search"
                        placeholder="Cari ruangan atau meeting..."
                        class="w-72 pl-9 pr-4 py-2.5 text-sm rounded-lg border border-gray-200 bg-white
                               focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
                    >
                </div>
            </form>
        </div>

        {{-- Grid Riwayat --}}
        @if (count($riwayats) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($riwayats as $riwayat)
                    {{--
                        Contoh markup kartu untuk nanti ketika data dari database
                        sudah tersedia. Sesuaikan nama field dengan struktur tabel.

                        $riwayat->ruangan->nama
                        $riwayat->judul_meeting
                        $riwayat->tanggal
                        $riwayat->jam_mulai / $riwayat->jam_selesai
                        $riwayat->jumlah_peserta
                        $riwayat->status (Selesai / Dibatalkan)
                    --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-5">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-gray-900">{{ $riwayat->ruangan->nama ?? '-' }}</h3>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $riwayat->status === 'Dibatalkan' ? 'bg-gray-200 text-gray-600' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $riwayat->status ?? '-' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $riwayat->judul_meeting ?? '-' }}</p>

                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 18.75h16.5A1.5 1.5 0 0 0 21.75 17.25V6.75A1.5 1.5 0 0 0 20.25 5.25H3.75A1.5 1.5 0 0 0 2.25 6.75v10.5A1.5 1.5 0 0 0 3.75 18.75Z" />
                                </svg>
                                {{ $riwayat->tanggal ?? '-' }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ $riwayat->jam_mulai ?? '-' }} - {{ $riwayat->jam_selesai ?? '-' }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                {{ $riwayat->jumlah_peserta ?? '-' }} Peserta
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty state: data belum tersedia karena belum terhubung database --}}
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