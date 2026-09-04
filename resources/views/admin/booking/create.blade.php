<x-layouts.detail title="Tambah Booking - RuangTemu">
    <div x-data="bookingForm()" x-init="init()">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-cyan-700 to-cyan-500 px-8 pt-8 pb-16">
            <div class="flex items-center gap-4 max-w-4xl mx-auto">
                <a href="{{ url()->previous() }}"
                    class="w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-lg transition">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-white">Tambah Booking</h1>
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

            <form method="POST" action="{{ route('admin.booking.store') }}">
                @csrf

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
                            <input type="text" name="nama_rapat" value="{{ old('nama_rapat') }}" required
                                placeholder="Contoh: Rapat Agustusan"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Agenda (Opsional)</label>
                            <textarea name="tujuan_rapat" rows="3"
                                placeholder="Tujuan dari diadakannya rapat..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 resize-none">{{ old('tujuan_rapat') }}</textarea>
                        </div>

                        {{-- Pilih Ruangan & Unit/Divisi --}}
                        <div class="mb-6 grid grid-cols-1 gap-4 rounded-xl border border-slate-200 p-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Pilih Ruangan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_ruangan" x-model="idRuangan" @change="onRuanganChange()" required
                                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($ruangans as $r)
                                    <option value="{{ $r->id }}"
                                        data-kapasitas="{{ $r->kapasitas }}"
                                        data-fasilitas="{{ $r->fasilitas->pluck('nama_fasilitas')->join(', ') }}"
                                        @selected(old('id_ruangan')==$r->id)>
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
                                    <option value="{{ $d->id }}" @selected(old('id_divisi')==$d->id)>
                                        {{ $d->nama_divisi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Info Kapasitas & Fasilitas Ruangan --}}
                        <div x-show="idRuangan" x-cloak
                            class="-mt-2 mb-6 flex items-start gap-3 rounded-xl bg-cyan-50/60 border border-cyan-100 px-4 py-3">
                            <div class="w-9 h-9 flex items-center justify-center bg-cyan-100 rounded-lg shrink-0">
                                <svg class="w-4 h-4 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                                </svg>
                            </div>
                            <div class="text-sm">
                                <p class="font-semibold text-gray-900">Kapasitas Ruangan</p>
                                <p class="text-gray-600 mt-0.5">
                                    Ruangan ini mendukung fasilitas: <span class="font-medium" x-text="fasilitasTerpilih"></span>.
                                    Kapasitas maksimal <span class="font-medium" x-text="kapasitasTerpilih"></span> orang.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" x-model="tanggal" @change="onTanggalChange()" required
                                value="{{ old('tanggal') }}"
                                class="w-full max-w-xs border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        </div>

                        {{-- Waktu Penggunaan Ruangan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Penggunaan Ruangan <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-400 mb-2">
                                Klik jam mulai, lalu klik jam selesai. Rentang di antaranya otomatis terpilih.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="slot in timeSlots" :key="slot">
                                    <button type="button"
                                        @click="pilihSlot(slot)"
                                        :disabled="isTerisi(slot)"
                                        :class="slotClasses(slot)"
                                        class="px-3 py-2 rounded-lg border text-sm font-medium transition"
                                        x-text="slot"></button>
                                </template>
                            </div>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-cyan-600"></span> Terpilih</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full border border-gray-300"></span> Tersedia</span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span> Terisi</span>
                            </div>
                            <p x-show="jamMulai && jamSelesai" x-cloak class="text-sm text-gray-600 mt-2">
                                Terpilih: <span class="font-semibold" x-text="jamMulai"></span> - <span class="font-semibold" x-text="jamSelesai"></span>
                            </p>
                            <input type="hidden" name="jam_masuk" x-model="jamMulai">
                            <input type="hidden" name="jam_keluar" x-model="jamSelesai">
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
                            <input type="text" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab') }}" required
                                placeholder="Contoh: Asep Agustian"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Tamu <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}"
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan Konsumsi (Opsional)</label>
                            <textarea name="catatan_konsumsi" rows="4"
                                placeholder="Contoh: Snack + kopi untuk 20 orang"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none">{{ old('catatan_konsumsi') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan Fasilitas (Opsional)</label>
                            <textarea name="catatan_fasilitas" rows="4"
                                placeholder="Contoh: Butuh proyektor tambahan"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none">{{ old('catatan_fasilitas') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function bookingForm() {
        return {
            tanggal: @json(old('tanggal', '')),
            idRuangan: @json(old('id_ruangan', '')),
            jamMulai: @json(old('jam_masuk', '')),
            jamSelesai: @json(old('jam_keluar', '')),
            totalPeserta: @json(old('total_peserta', 1)),

            terisiList: [],
            kapasitasTerpilih: '-',
            fasilitasTerpilih: '-',
            timeSlots: @json($timeSlots),

            init() {
                this.ruanganDipilih();

                if (this.idRuangan && this.tanggal) {
                    this.cekAvailability();
                }
            },

            ruanganDipilih() {
                const select = document.querySelector('select[name="id_ruangan"]');
                const opt = select.options[select.selectedIndex];

                this.kapasitasTerpilih =
                    opt?.dataset?.kapasitas || '-';

                this.fasilitasTerpilih =
                    opt?.dataset?.fasilitas || '-';
            },

            resetSelection() {
                this.jamMulai = '';
                this.jamSelesai = '';
                this.terisiList = [];
            },

            onRuanganChange() {
                this.ruanganDipilih();
                this.resetSelection();
                this.cekAvailability();
            },

            onTanggalChange() {
                this.resetSelection();
                this.cekAvailability();
            },

            isTerisi(slot) {
                return this.terisiList.includes(slot);
            },

            inRange(slot) {
                if (!this.jamMulai) return false;

                if (!this.jamSelesai) {
                    return slot === this.jamMulai;
                }

                return slot >= this.jamMulai &&
                       slot <= this.jamSelesai;
            },

            rangeHasConflict(start, end) {
                const startIdx = this.timeSlots.indexOf(start);
                const endIdx = this.timeSlots.indexOf(end);

                for (let i = startIdx; i < endIdx; i++) {
                    if (this.terisiList.includes(this.timeSlots[i])) {
                        return true;
                    }
                }

                return false;
            },

            pilihSlot(slot) {
                if (this.isTerisi(slot)) return;

                if (!this.jamMulai ||
                    (this.jamMulai && this.jamSelesai)) {

                    this.jamMulai = slot;
                    this.jamSelesai = '';
                    return;
                }

                if (slot <= this.jamMulai) {
                    this.jamMulai = slot;
                    this.jamSelesai = '';
                    return;
                }

                if (this.rangeHasConflict(this.jamMulai, slot)) {
                    this.jamMulai = slot;
                    this.jamSelesai = '';
                    return;
                }

                this.jamSelesai = slot;
            },

            slotClasses(slot) {
                if (this.isTerisi(slot)) {
                    return 'bg-gray-100 border-gray-200 text-gray-300 cursor-not-allowed';
                }

                if (this.inRange(slot)) {
                    return 'bg-cyan-600 border-cyan-600 text-white';
                }

                return 'bg-white border-gray-300 text-gray-700 hover:border-cyan-400';
            },

            async cekAvailability() {
                if (!this.idRuangan || !this.tanggal) return;

                try {
                    const res = await fetch(
                        `{{ route('admin.booking.availability') }}?id_ruangan=${this.idRuangan}&tanggal=${this.tanggal}`
                    );

                    const data = await res.json();

                    this.terisiList = data.terisi || [];

                } catch (e) {
                    console.error(
                        'Gagal cek ketersediaan:',
                        e
                    );
                }
            }
        }
    }
</script>
</x-layouts.detail>