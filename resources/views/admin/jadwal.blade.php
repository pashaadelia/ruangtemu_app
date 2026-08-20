<x-layouts.app title="Jadwal Ruangan - RuangTemu">
    <div x-data="{ selectedDate: null, selectedBookings: [] }">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Jadwal Ruangan</h1>
                <p class="text-gray-500 mt-1">Kelola dan tinjau semua jadwal penggunaan ruangan.</p>
            </div>

            <div class="flex items-center gap-3">
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
        </div>

        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.booking.create') }}"
               class="flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan
            </a>
        </div>

        {{-- Kalender --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

            {{-- Header bulan + navigasi --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">
                    {{ $current->translatedFormat('F Y') }}
                </h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.jadwal', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
                       class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin.jadwal') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Hari Ini
                    </a>
                    <a href="{{ route('admin.jadwal', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
                       class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Nama hari --}}
            <div class="grid grid-cols-7 border-b border-gray-100">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $namaHari)
                    <div class="py-3 text-center text-sm font-medium text-gray-500">
                        {{ $namaHari }}
                    </div>
                @endforeach
            </div>

            {{-- Grid tanggal --}}
            @foreach ($weeks as $week)
                <div class="grid grid-cols-7 border-b border-gray-100 last:border-b-0">
                    @foreach ($week as $day)
                        @php
                            $bookingsForDay = $day['bookings'];
                            $visibleBookings = $bookingsForDay->take(3);
                            $moreCount = $bookingsForDay->count() - 3;
                        @endphp
                        <div class="min-h-[110px] border-r border-gray-100 last:border-r-0 p-2 {{ !$day['inMonth'] ? 'bg-gray-50/50' : '' }} {{ $day['isToday'] ? 'ring-2 ring-inset ring-cyan-500' : '' }}">
                            <div class="flex justify-between items-start mb-1">
                                @if ($day['isToday'])
                                    <span class="w-6 h-6 flex items-center justify-center bg-cyan-600 text-white text-xs font-bold rounded-full">
                                        {{ $day['date']->day }}
                                    </span>
                                @else
                                    <span class="text-sm {{ $day['inMonth'] ? 'text-gray-700' : 'text-gray-300' }}">
                                        {{ $day['date']->day }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                @foreach ($visibleBookings as $b)
                                    <a href="{{ route('admin.booking.show', $b->id) }}"
                                       class="block text-[11px] leading-tight bg-cyan-50 text-cyan-700 rounded px-1.5 py-1 truncate hover:bg-cyan-100 transition">
                                        {{ \Carbon\Carbon::parse($b->jam_masuk)->format('H:i') }} - {{ $b->ruangan->nama_ruangan }}
                                    </a>
                                @endforeach

                                @if ($moreCount > 0)
                                    <p class="text-[11px] text-gray-400 px-1.5">+{{ $moreCount }} lainnya</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>