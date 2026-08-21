@props(['booking', 'editable' => false])

@php
    $statusConfig = [
        0 => ['label' => 'Menunggu',    'class' => 'bg-cyan-100 text-cyan-700'],
        1 => ['label' => 'Disetujui', 'class' => 'bg-blue-100 text-blue-700'],
        2 => ['label' => 'Dibatalkan',  'class' => 'bg-red-100 text-red-700'],
        3 => ['label' => 'Selesai',     'class' => 'bg-green-100 text-green-700'],
    ];
    $status = $statusConfig[$booking->status_booking] ?? $statusConfig[0];

    $detailRoute = request()->is('admin/*')
        ? route('admin.booking.show', $booking->id)
        : route('user.booking.show', $booking->id);

    $editRoute = Route::has('admin.booking.edit')
        ? route('admin.booking.edit', $booking->id)
        : '#';
@endphp

<a href="{{ $detailRoute }}"
   class="block bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-cyan-300 transition cursor-pointer">
    <div class="flex items-start justify-between mb-1">
        <h3 class="font-bold text-gray-900">{{ $booking->ruangan->nama_ruangan }}</h3>
        <span class="text-xs font-medium px-3 py-1 rounded-full whitespace-nowrap {{ $status['class'] }}">
            {{ $status['label'] }}
        </span>
    </div>

    <p class="text-gray-500 text-sm mb-3">{{ $booking->nama_rapat }}</p>

    <div class="space-y-1.5 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ \Carbon\Carbon::parse($booking->jam_masuk)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($booking->jam_keluar)->format('H:i') }} WIB
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/>
            </svg>
            {{ $booking->total_peserta }} Peserta
        </div>
    </div>

    @if ($editable)
        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
            <span onclick="event.preventDefault(); window.location='{{ $editRoute }}'"
                  class="text-cyan-600 hover:text-cyan-700 relative z-10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </span>
        </div>
    @endif
</a>