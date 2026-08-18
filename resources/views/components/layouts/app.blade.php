<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RuangTemu' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-100 border-r border-gray-200 flex flex-col">
            <div class="p-6 flex items-center gap-3">
                <img src="{{ auth()->user()->foto_profil ? asset(auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    alt="Foto profil"
                    class="w-11 h-11 rounded-full object-cover">
                <div>
                    <p class="font-bold text-cyan-600 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->divisi->nama_divisi ?? 'Divisi Admin dan Keuangan' }}</p>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h4v8H3v-8zM10 3h4v18h-4V3zM17 8h4v13h-4V8z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ Route::has('admin.jadwal') ? route('admin.jadwal') : '#' }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('admin.jadwal') ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Jadwal Ruangan
                </a>

                <a href="{{ Route::has('admin.riwayat') ? route('admin.riwayat') : '#' }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('admin.riwayat') ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat
                </a>

                <a href="{{ Route::has('admin.pengaturan') ? route('admin.pengaturan') : '#' }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
              {{ request()->routeIs('admin.pengaturan') ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Pengaturan
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>