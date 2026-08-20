<x-layouts.detail title="Detail Rapat - RuangTemu">
    @php
        $statusConfig = [
            'menunggu'  => ['label' => 'Menunggu',   'class' => 'bg-white/20 text-white'],
            'disetujui' => ['label' => 'Berlangsung', 'class' => 'bg-white/20 text-white'],
            'selesai'   => ['label' => 'Selesai',    'class' => 'bg-white/20 text-white'],
            'ditolak'   => ['label' => 'Dibatalkan', 'class' => 'bg-white/20 text-white'],
        ];
        $status = $statusConfig[$booking->status_booking] ?? $statusConfig['menunggu'];
    @endphp

    {{-- Header full-width dengan gradient --}}
    <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 px-8 pt-8 pb-16">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}"
                   class="w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-lg transition">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-white">Detail Rapat</h1>
            </div>
            <span class="px-4 py-1.5 rounded-lg text-sm font-medium {{ $status['class'] }}">
                {{ $status['label'] }}
            </span>
        </div>
    </div>

    {{-- Konten --}}
    <div class="max-w-7xl mx-auto px-8 -mt-10 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri (2/3) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card Ruangan & Waktu --}}
                <div class="bg-white rounded-xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex gap-3">
                        <div class="w-11 h-11 flex items-center justify-center bg-cyan-50 rounded-lg shrink-0">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium tracking-wide">RUANGAN</p>
                            <p class="text-lg font-bold text-gray-900 leading-tight">{{ $booking->ruangan->nama_ruangan }}</p>
                            <p class="text-sm text-gray-500 mt-1">Kapasitas {{ $booking->ruangan->kapasitas }} Orang</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-11 h-11 flex items-center justify-center bg-cyan-50 rounded-lg shrink-0">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium tracking-wide">WAKTU</p>
                            <p class="text-lg font-bold text-gray-900 leading-tight">
                                {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($booking->jam_masuk)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->jam_keluar)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Subjek & Agenda --}}
                <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Subjek Rapat</p>
                        <p class="text-gray-900">{{ $booking->nama_rapat }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-lg font-bold text-gray-900 mb-1">Agenda Rapat</p>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $booking->tujuan_rapat }}</p>
                    </div>
                </div>

                {{-- Card Divisi & Peserta --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Divisi {{ $booking->divisi->nama_divisi }}</h2>
                    </div>

                    <p class="text-xs text-gray-400 font-medium tracking-wide mb-1.5">PENANGGUNG JAWAB RAPAT</p>
                    <div class="bg-gray-50 rounded-lg px-4 py-3 mb-4">
                        <p class="font-semibold text-gray-900">{{ $booking->nama_penanggung_jawab }}</p>
                        <p class="text-sm text-gray-500">Divisi {{ $booking->divisi->nama_divisi }}</p>
                    </div>

                    @if ($booking->nama_tamu)
                        <p class="text-xs text-gray-400 font-medium tracking-wide mb-1.5">TAMU</p>
                        <div class="bg-gray-50 rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-gray-900">{{ $booking->nama_tamu }}</span>
                        </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg px-4 py-3 flex items-center justify-between">
                        <span class="text-gray-600">Total Peserta</span>
                        <span class="text-2xl font-bold text-gray-900">{{ $booking->total_peserta }}</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan (1/3) --}}
            <div class="space-y-6">

                @if ($booking->informasi_tambahan)
                    <div class="bg-cyan-50/60 rounded-xl border-t-2 border-cyan-500 p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/>
                            </svg>
                            <h2 class="font-bold text-gray-900">Informasi Tambahan</h2>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $booking->informasi_tambahan }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="font-bold text-gray-900 mb-4">Fasilitas Ruangan</h2>
                    <div class="grid grid-cols-2 gap-3">
                        @forelse ($booking->ruangan->fasilitas as $f)
                            <div class="border border-gray-200 rounded-lg p-3 flex flex-col items-center text-center gap-1.5">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-600">{{ $f->nama_fasilitas }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 col-span-2">Belum ada fasilitas terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.detail>