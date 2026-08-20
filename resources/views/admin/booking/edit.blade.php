<x-layouts.detail title="Edit Booking - RuangTemu">
    <div x-data="editBookingForm()" x-init="init()">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 px-8 pt-8 pb-16">
            <div class="flex items-center gap-4 max-w-4xl mx-auto">
                <a href="{{ url()->previous() }}"
                   class="w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-lg transition">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-white">Edit Ruang Rapat</h1>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-8 -mt-10 pb-10">

            @if ($errors->any())
                <div class="mb-6 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.booking.update', $booking->id) }}">
                @csrf
                @method('PUT')

                {{-- 1. Detail Rapat --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">1</span>
                        <h2 class="text-xl font-bold text-gray-900">Detail Rapat</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Subjek Rapat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_rapat" value="{{ old('nama_rapat', $booking->nama_rapat) }}" required
                                   placeholder="Contoh: Rapat Agustusan"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Agenda (Opsional)</label>
                            <textarea name="tujuan_rapat" rows="3"
                                      placeholder="Tujuan dari diadakannya rapat..."
                                      class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 resize-none">{{ old('tujuan_rapat', $booking->tujuan_rapat) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" x-model="tanggal" @change="cekAvailability()" required
                                   value="{{ old('tanggal', \Illuminate\Support\Carbon::parse($booking->tanggal)->format('Y-m-d')) }}"
                                   class="w-full max-w-xs border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        </div>

                        {{-- Waktu Masuk --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Masuk <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($timeSlots as $slot)
                                    <button type="button"
                                            @click="pilihJamMasuk('{{ $slot }}')"
                                            :disabled="isDisabledMasuk('{{ $slot }}')"
                                            :class="{
                                                'bg-cyan-600 border-cyan-600 text-white': jamMasuk === '{{ $slot }}',
                                                'bg-gray-100 border-gray-200 text-gray-300 cursor-not-allowed': isDisabledMasuk('{{ $slot }}'),
                                                'bg-white border-gray-300 text-gray-700 hover:border-cyan-400': jamMasuk !== '{{ $slot }}' && !isDisabledMasuk('{{ $slot }}')
                                            }"
                                            class="px-3 py-2 rounded-lg border text-sm font-medium transition">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-cyan-600"></span> Terpilih</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full border border-gray-300"></span> Tersedia</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span> Terisi</span>
                            </div>
                            <input type="hidden" name="jam_masuk" x-model="jamMasuk">
                        </div>

                        {{-- Waktu Keluar --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Keluar <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($timeSlots as $slot)
                                    <button type="button"
                                            @click="pilihJamKeluar('{{ $slot }}')"
                                            :disabled="isDisabledKeluar('{{ $slot }}')"
                                            :class="{
                                                'bg-cyan-600 border-cyan-600 text-white': jamKeluar === '{{ $slot }}',
                                                'bg-gray-100 border-gray-200 text-gray-300 cursor-not-allowed': isDisabledKeluar('{{ $slot }}'),
                                                'bg-white border-gray-300 text-gray-700 hover:border-cyan-400': jamKeluar !== '{{ $slot }}' && !isDisabledKeluar('{{ $slot }}')
                                            }"
                                            class="px-3 py-2 rounded-lg border text-sm font-medium transition">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-cyan-600"></span> Terpilih</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full border border-gray-300"></span> Tersedia</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span> Terisi</span>
                            </div>
                            <input type="hidden" name="jam_keluar" x-model="jamKeluar">
                        </div>

                        {{-- Pilih Ruangan & Unit/Divisi --}}
                        <div class="bg-gray-50 rounded-lg p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Pilih Ruangan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_ruangan" x-model="idRuangan" @change="ruanganDipilih(); cekAvailability()" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($ruangans as $r)
                                        <option value="{{ $r->id }}"
                                                data-kapasitas="{{ $r->kapasitas }}"
                                                data-fasilitas="{{ $r->fasilitas->pluck('nama_fasilitas')->join(', ') }}"
                                                @selected(old('id_ruangan', $booking->id_ruangan) == $r->id)>
                                            {{ $r->nama_ruangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Unit / Divisi <span class="text-red-500">*</span>
                                </label>
                                <select name="id_divisi" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                    <option value="">Pilih Unit / Divisi</option>
                                    @foreach ($divisis as $d)
                                        <option value="{{ $d->id }}" @selected(old('id_divisi', $booking->id_divisi) == $d->id)>
                                            {{ $d->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="bg-gray-50 rounded-lg p-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status_booking" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status_booking', $booking->status_booking) === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Info Kapasitas --}}
                        <div x-show="idRuangan" x-cloak class="bg-cyan-50/60 rounded-lg p-4 flex gap-3">
                            <svg class="w-5 h-5 text-cyan-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                            </svg>
                            <div class="text-sm text-gray-600">
                                <p class="font-semibold text-gray-900 mb-0.5">Kapasitas Ruangan</p>
                                <p>Selected room supports: <span x-text="fasilitasTerpilih"></span>. Max capacity <span x-text="kapasitasTerpilih"></span> orang.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Daftar Peserta Rapat --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">2</span>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Peserta Rapat</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Penanggung Jawab Rapat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', $booking->nama_penanggung_jawab) }}" required
                                   placeholder="Contoh: Asep Agustian"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Tamu <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $booking->nama_tamu) }}"
                                       placeholder="Nama Tamu / Perusahaan"
                                       class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Total Peserta <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="total_peserta" x-model="totalPeserta" min="1" required
                                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 pr-12 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                    <button type="button" @click="totalPeserta++"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center text-gray-500 hover:text-cyan-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Catatan --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">3</span>
                        <h2 class="text-xl font-bold text-gray-900">Catatan</h2>
                    </div>
                    <textarea name="catatan" rows="4"
                              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none">{{ old('catatan', $booking->catatan) }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                        Ubah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
       function editBookingForm() {
    return {
        tanggal: '{{ old('tanggal', \Illuminate\Support\Carbon::parse($booking->tanggal)->format('Y-m-d')) }}',
        idRuangan: '{{ old('id_ruangan', $booking->id_ruangan) }}',
        jamMasuk: '{{ old('jam_masuk', \Illuminate\Support\Carbon::parse($booking->jam_masuk)->format('H:i')) }}',
        jamKeluar: '{{ old('jam_keluar', \Illuminate\Support\Carbon::parse($booking->jam_keluar)->format('H:i')) }}',
        totalPeserta: {{ old('total_peserta', $booking->total_peserta) }},
        terisiList: [],
        kapasitasTerpilih: '-',
        fasilitasTerpilih: '-',

        init() {
            this.ruanganDipilih();
            if (this.idRuangan && this.tanggal) {
                this.cekAvailability();
            }
        },

        ruanganDipilih() {
            const select = document.querySelector('select[name="id_ruangan"]');
            const opt = select.options[select.selectedIndex];
            this.kapasitasTerpilih = opt?.dataset?.kapasitas || '-';
            this.fasilitasTerpilih = opt?.dataset?.fasilitas || '-';
        },

        isTerisi(slot) {
            return this.terisiList.includes(slot);
        },

        // Waktu Masuk: disable kalau terisi ATAU sama persis dengan jam keluar yang sudah dipilih
        isDisabledMasuk(slot) {
            if (this.isTerisi(slot)) return true;
            if (this.jamKeluar && slot === this.jamKeluar) return true;
            return false;
        },

        // Waktu Keluar: disable kalau terisi ATAU sama persis dengan jam masuk yang sudah dipilih
        isDisabledKeluar(slot) {
            if (this.isTerisi(slot)) return true;
            if (this.jamMasuk && slot === this.jamMasuk) return true;
            return false;
        },

        pilihJamMasuk(slot) {
            if (this.isDisabledMasuk(slot)) return;
            this.jamMasuk = slot;
        },

        pilihJamKeluar(slot) {
            if (this.isDisabledKeluar(slot)) return;
            this.jamKeluar = slot;
        },

        async cekAvailability() {
            if (!this.idRuangan || !this.tanggal) return;

            try {
                // exclude_booking_id dikirim supaya slot booking ini sendiri tidak dianggap "terisi"
                const res = await fetch(`{{ route('admin.booking.availability') }}?id_ruangan=${this.idRuangan}&tanggal=${this.tanggal}&exclude_booking_id={{ $booking->id }}`);
                const data = await res.json();
                this.terisiList = data.terisi || [];
            } catch (e) {
                console.error('Gagal cek ketersediaan:', e);
            }
        }
    }
}

    </script>
</x-layouts.detail>