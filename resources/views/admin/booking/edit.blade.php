{{-- resources/views/admin/booking/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Ruang Rapat')

@section('content')
<div
    x-data="editRuangRapat({
        idRuangan: '{{ old('id_ruangan', $booking->id_ruangan) }}',
        tanggal: '{{ old('tanggal', \Carbon\Carbon::parse($booking->tanggal)->format('Y-m-d')) }}',
        excludeId: {{ $booking->id }},
        selectedMasuk: '{{ old('jam_masuk', \Carbon\Carbon::parse($booking->jam_masuk)->format('H:i')) }}',
        selectedKeluar: '{{ old('jam_keluar', \Carbon\Carbon::parse($booking->jam_keluar)->format('H:i')) }}',
        timeSlots: {{ json_encode($timeSlots) }},
        totalPeserta: {{ (int) old('total_peserta', $booking->total_peserta) }},
        availabilityUrl: '{{ route('admin.booking.availability') }}',
    })"
    x-init="loadAvailability()"
    class="min-h-screen bg-gradient-to-b from-sky-100 via-slate-100 to-slate-100"
>
    {{-- Header --}}
    <header class="bg-gradient-to-b from-cyan-700 via-cyan-500 to-sky-300 px-6 pt-8 pb-20 sm:px-10">
        <div class="mx-auto flex max-w-3xl items-center gap-4">
            <a
                href="{{ url()->previous() }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/25 text-white transition hover:bg-white/35"
                aria-label="Kembali"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-semibold text-white sm:text-4xl">Edit Ruang Rapat</h1>
        </div>
    </header>

    <form
        method="POST"
        action="{{ route('admin.booking.update', $booking) }}"
        class="mx-auto -mt-12 max-w-3xl space-y-6 px-4 pb-16 sm:px-6"
    >
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Section 1: Detail Rapat --}}
        <section class="rounded-2xl bg-white p-6 shadow-lg shadow-slate-300/40 sm:p-8">
            <div class="mb-6 flex items-center gap-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-700 text-xs font-semibold text-white">1</span>
                <h2 class="text-xl font-semibold text-slate-800">Detail Rapat</h2>
            </div>

            {{-- Nama Rapat --}}
            <div class="mb-5">
                <label for="nama_rapat" class="mb-2 block text-sm font-medium text-slate-700">
                    Subjek Rapat <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_rapat"
                    name="nama_rapat"
                    value="{{ old('nama_rapat', $booking->nama_rapat) }}"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                >
            </div>

            {{-- Tujuan Rapat --}}
            <div class="mb-5">
                <label for="tujuan_rapat" class="mb-2 block text-sm font-medium text-slate-700">Agenda (Opsional)</label>
                <textarea
                    id="tujuan_rapat"
                    name="tujuan_rapat"
                    rows="3"
                    class="w-full resize-none rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                >{{ old('tujuan_rapat', $booking->tujuan_rapat) }}</textarea>
            </div>

            {{-- Tanggal --}}
            <div class="mb-6">
                <label for="tanggal" class="mb-2 block text-sm font-medium text-slate-700">
                    Date <span class="text-rose-500">*</span>
                </label>
                <div class="max-w-xs">
                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        x-model="tanggal"
                        @change="loadAvailability()"
                        required
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                    >
                </div>
            </div>

            {{-- Waktu Masuk --}}
            <div class="mb-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Waktu Masuk <span class="text-rose-500">*</span>
                </label>
                <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1">
                    <template x-for="slot in timeSlots" :key="'masuk-' + slot">
                        <button
                            type="button"
                            :disabled="terisi.includes(slot)"
                            @click="!terisi.includes(slot) && (selectedMasuk = slot)"
                            :class="slotClasses(slot, selectedMasuk)"
                            class="shrink-0 rounded-lg border px-4 py-2 text-sm font-medium transition"
                            x-text="slot"
                        ></button>
                    </template>
                </div>
                <input type="hidden" name="jam_masuk" :value="selectedMasuk">
            </div>
            <p class="mb-6 flex items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-cyan-700"></span> Terpilih</span>
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full border border-slate-400"></span> Tersedia</span>
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-slate-300"></span> Terisi</span>
            </p>

            {{-- Waktu Keluar --}}
            <div class="mb-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Waktu Keluar <span class="text-rose-500">*</span>
                </label>
                <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1">
                    <template x-for="slot in timeSlots" :key="'keluar-' + slot">
                        <button
                            type="button"
                            :disabled="terisi.includes(slot)"
                            @click="!terisi.includes(slot) && (selectedKeluar = slot)"
                            :class="slotClasses(slot, selectedKeluar)"
                            class="shrink-0 rounded-lg border px-4 py-2 text-sm font-medium transition"
                            x-text="slot"
                        ></button>
                    </template>
                </div>
                <input type="hidden" name="jam_keluar" :value="selectedKeluar">
            </div>
            <p class="mb-6 flex items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-cyan-700"></span> Terpilih</span>
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full border border-slate-400"></span> Tersedia</span>
                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-slate-300"></span> Terisi</span>
            </p>

            {{-- Ruangan / Divisi --}}
            <div class="mb-6 grid grid-cols-1 gap-4 rounded-xl border border-slate-200 p-4 sm:grid-cols-2">
                <div>
                    <label for="id_ruangan" class="mb-2 block text-sm font-medium text-slate-700">
                        Pilih Ruangan <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="id_ruangan"
                        name="id_ruangan"
                        x-model="idRuangan"
                        @change="loadAvailability()"
                        required
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                    >
                        @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}" @selected(old('id_ruangan', $booking->id_ruangan) == $ruangan->id)>
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="id_divisi" class="mb-2 block text-sm font-medium text-slate-700">
                        Unit / Divisi <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="id_divisi"
                        name="id_divisi"
                        required
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                    >
                        @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id }}" @selected(old('id_divisi', $booking->id_divisi) == $divisi->id)>
                                {{ $divisi->nama_divisi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-6 rounded-xl border border-slate-200 p-4">
                <label for="status_booking" class="mb-2 block text-sm font-medium text-slate-700">
                    Status <span class="text-rose-500">*</span>
                </label>
                @php
                    $statusOptions = [
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'berlangsung' => 'Berlangsung',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ];
                @endphp
                <select
                    id="status_booking"
                    name="status_booking"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                >
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('status_booking', $booking->status_booking) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Kapasitas Ruangan info --}}
            <div class="flex items-start gap-3 rounded-xl bg-sky-50 p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m-1 4h1m4-4h1m-1 4h1M9 21v-4h6v4" />
                </svg>
                <div>
                    <p class="font-medium text-slate-700">Kapasitas Ruangan</p>
                    <p class="text-sm text-slate-500">
                        @foreach ($ruangans as $ruangan)
                            <template x-if="idRuangan == '{{ $ruangan->id }}'">
                                <span>
                                    Kapasitas: {{ $ruangan->kapasitas }} orang.
                                    Fasilitas: {{ $ruangan->fasilitas->pluck('nama_fasilitas')->join(', ') ?: '-' }}.
                                </span>
                            </template>
                        @endforeach
                    </p>
                </div>
            </div>
        </section>

        {{-- Section 2: Daftar Peserta Rapat --}}
        <section class="rounded-2xl bg-white p-6 shadow-lg shadow-slate-300/40 sm:p-8">
            <div class="mb-6 flex items-center gap-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-700 text-xs font-semibold text-white">2</span>
                <h2 class="text-xl font-semibold text-slate-800">Daftar Peserta Rapat</h2>
            </div>

            <div class="mb-5">
                <label for="nama_penanggung_jawab" class="mb-2 block text-sm font-medium text-slate-700">
                    Penanggung Jawab Rapat <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_penanggung_jawab"
                    name="nama_penanggung_jawab"
                    value="{{ old('nama_penanggung_jawab', $booking->nama_penanggung_jawab) }}"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                >
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="nama_tamu" class="mb-2 block text-sm font-medium text-slate-700">Tamu</label>
                    <input
                        type="text"
                        id="nama_tamu"
                        name="nama_tamu"
                        value="{{ old('nama_tamu', $booking->nama_tamu) }}"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
                    >
                </div>
                <div>
                    <label for="total_peserta" class="mb-2 block text-sm font-medium text-slate-700">
                        Total Peserta <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center rounded-lg border border-slate-200 bg-slate-50">
                        <input
                            type="number"
                            id="total_peserta"
                            name="total_peserta"
                            min="1"
                            x-model.number="totalPeserta"
                            required
                            class="w-full bg-transparent px-4 py-3 text-slate-800 outline-none"
                        >
                        <button
                            type="button"
                            @click="totalPeserta++"
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-md text-slate-500 transition hover:bg-slate-200"
                            aria-label="Tambah peserta"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Catatan --}}
        <section class="rounded-2xl bg-white p-6 shadow-lg shadow-slate-300/40 sm:p-8">
            <div class="mb-6 flex items-center gap-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-700 text-xs font-semibold text-white">3</span>
                <h2 class="text-xl font-semibold text-slate-800">Catatan</h2>
            </div>
            <textarea
                name="catatan"
                rows="4"
                class="w-full resize-none rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"
            >{{ old('catatan', $booking->catatan) }}</textarea>
        </section>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-xl bg-gradient-to-r from-cyan-600 to-sky-500 px-10 py-3 font-semibold text-white shadow-lg shadow-cyan-500/30 transition hover:from-cyan-700 hover:to-sky-600"
            >
                Ubah
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function editRuangRapat(config) {
        return {
            ...config,
            terisi: [],
            slotClasses(slot, selected) {
                if (this.terisi.includes(slot)) {
                    return 'cursor-not-allowed border-slate-100 bg-slate-100 text-slate-300';
                }
                if (slot === selected) {
                    return 'border-cyan-700 bg-cyan-700 text-white';
                }
                return 'border-slate-200 bg-white text-slate-700 hover:border-cyan-400 hover:bg-cyan-50';
            },
            async loadAvailability() {
                if (!this.idRuangan || !this.tanggal) return;

                const params = new URLSearchParams({
                    id_ruangan: this.idRuangan,
                    tanggal: this.tanggal,
                    exclude_id: this.excludeId,
                });

                try {
                    const res = await fetch(`${this.availabilityUrl}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    this.terisi = data.terisi ?? [];
                } catch (e) {
                    console.error('Gagal memuat ketersediaan jam:', e);
                }
            },
        };
    }
</script>
@endpush