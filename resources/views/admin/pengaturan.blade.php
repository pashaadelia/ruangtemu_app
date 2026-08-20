<x-layouts.app title="Pengaturan">

    <div class="max-w-5xl">
        <h1 class="text-3xl font-extrabold text-slate-900">Pengaturan</h1>
        <p class="text-slate-500 mt-1 mb-8">Kelola dan tinjau semua jadwal penggunaan ruangan.</p>

        @if (session('status'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            {{-- ================= PROFIL ================= --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5 text-cyan-600">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" d="M4.5 20c1.3-3.5 4-5.5 7.5-5.5s6.2 2 7.5 5.5"/>
                    </svg>
                    <h2 class="font-semibold text-slate-800">Profil</h2>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.profil') }}"
                      enctype="multipart/form-data"
                      x-data="profileForm()"
                      @submit="saving = true">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-center mb-8">
                        <div class="relative w-28 h-28">
                            <img :src="preview" alt="Foto profil"
                                 class="w-28 h-28 rounded-full object-cover ring-4 ring-white shadow object-center">

                            <label for="foto_profil"
                                   class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-cyan-600 hover:bg-cyan-700
                                          flex items-center justify-center cursor-pointer ring-2 ring-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h3l1.5-2h7L17 8h3a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                    <circle cx="12" cy="13" r="3.5"/>
                                </svg>
                            </label>
                            <input id="foto_profil" name="foto_profil" type="file" accept="image/*" class="hidden"
                                   @change="onAvatarChange($event)">
                        </div>
                    </div>
                    @error('foto_profil')
                        <p class="text-xs text-red-600 text-center -mt-6 mb-4">{{ $message }}</p>
                    @enderror

                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Pengguna</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', $user->name ?? 'Administrator') }}"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 mb-5">
                    @error('name')
                        <p class="text-xs text-red-600 -mt-4 mb-4">{{ $message }}</p>
                    @enderror

                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $user->email ?? 'admin@gmail.com') }}"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 mb-6">
                    @error('email')
                        <p class="text-xs text-red-600 -mt-5 mb-4">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-center">
                        <button type="submit" :disabled="saving"
                                class="bg-cyan-600 hover:bg-cyan-700 disabled:opacity-60 disabled:cursor-not-allowed
                                       text-white font-semibold text-sm px-6 py-2.5 rounded-lg transition
                                       inline-flex items-center gap-2">
                            <svg x-show="saving" x-cloak class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                            </svg>
                            <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'">Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- ================= KEAMANAN ================= --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5 text-cyan-600">
                        <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                        <path stroke-linecap="round" d="M8 10.5V7a4 4 0 0 1 8 0v3.5"/>
                    </svg>
                    <h2 class="font-semibold text-slate-800">Keamanan</h2>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.keamanan') }}"
                      x-data="securityForm()"
                      @submit="updating = true">
                    @csrf
                    @method('PUT')

                    <label for="current_password" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                    <div class="relative mb-5">
                        <input :type="showCurrent ? 'text' : 'password'"
                               id="current_password" name="current_password"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-10 text-sm text-slate-700
                                      focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <button type="button" @click="showCurrent = !showCurrent"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg x-show="!showCurrent" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showCurrent" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.7a2 2 0 0 0 2.7 2.7M6.5 6.7C4 8.3 2 12 2 12s3.5 7 10 7c1.8 0 3.4-.5 4.7-1.2M9.9 5.2A9.8 9.8 0 0 1 12 5c6.5 0 10 7 10 7-.4.8-1.3 2.1-2.6 3.4"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-xs text-red-600 -mt-4 mb-4">{{ $message }}</p>
                    @enderror

                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                    <div class="relative mb-5">
                        <input :type="showNew ? 'text' : 'password'"
                               id="password" name="password" x-model="newPassword"
                               placeholder="Min. 8 karakter"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-10 text-sm text-slate-700
                                      placeholder:text-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        <button type="button" @click="showNew = !showNew"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg x-show="!showNew" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showNew" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.7a2 2 0 0 0 2.7 2.7M6.5 6.7C4 8.3 2 12 2 12s3.5 7 10 7c1.8 0 3.4-.5 4.7-1.2M9.9 5.2A9.8 9.8 0 0 1 12 5c6.5 0 10 7 10 7-.4.8-1.3 2.1-2.6 3.4"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 -mt-4 mb-4">{{ $message }}</p>
                    @enderror

                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative mb-2">
                        <input :type="showConfirm ? 'text' : 'password'"
                               id="password_confirmation" name="password_confirmation" x-model="confirmPassword"
                               placeholder="Ulangi kata sandi"
                               class="w-full rounded-lg border px-4 py-2.5 pr-10 text-sm text-slate-700
                                      placeholder:text-slate-400 focus:outline-none focus:ring-2
                                      transition
                                      border-slate-300 focus:ring-cyan-500 focus:border-cyan-500"
                               :class="confirmPassword && confirmPassword !== newPassword ? 'border-red-300 focus:ring-red-400 focus:border-red-400' : ''">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showConfirm" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.7a2 2 0 0 0 2.7 2.7M6.5 6.7C4 8.3 2 12 2 12s3.5 7 10 7c1.8 0 3.4-.5 4.7-1.2M9.9 5.2A9.8 9.8 0 0 1 12 5c6.5 0 10 7 10 7-.4.8-1.3 2.1-2.6 3.4"/>
                            </svg>
                        </button>
                    </div>
                    <p x-show="confirmPassword && confirmPassword !== newPassword" x-cloak
                       class="text-xs text-red-600 mb-4">Konfirmasi kata sandi tidak sama.</p>
                    @error('password_confirmation')
                        <p class="text-xs text-red-600 mb-4">{{ $message }}</p>
                    @enderror

                    <div class="mt-6">
                        <button type="submit" :disabled="updating || (confirmPassword && confirmPassword !== newPassword)"
                                class="bg-cyan-600 hover:bg-cyan-700 disabled:opacity-60 disabled:cursor-not-allowed
                                       text-white font-semibold text-sm px-6 py-2.5 rounded-lg transition
                                       inline-flex items-center gap-2">
                            <svg x-show="updating" x-cloak class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                            </svg>
                            <span x-text="updating ? 'Memperbarui...' : 'Update Keamanan'">Update Keamanan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function profileForm() {
            return {
                saving: false,
                preview: @json($user->foto_profil ? asset($user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name)),
                onAvatarChange(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    this.preview = URL.createObjectURL(file);
                },
            };
        }

        function securityForm() {
            return {
                updating: false,
                showCurrent: false,
                showNew: false,
                showConfirm: false,
                newPassword: '',
                confirmPassword: '',
            };
        }
    </script>
    @endpush
</x-layouts.app>