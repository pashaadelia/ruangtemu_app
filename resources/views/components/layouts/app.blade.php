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
                @php
                    $menus = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'chart'],
                        ['label' => 'Jadwal Ruangan', 'route' => 'admin.jadwal', 'icon' => 'calendar'],
                        ['label' => 'Riwayat', 'route' => 'admin.riwayat', 'icon' => 'clock'],
                        ['label' => 'Pengaturan', 'route' => 'admin.pengaturan', 'icon' => 'gear'],
                    ];
                @endphp

                @foreach ($menus as $menu)
                    @php $active = request()->routeIs($menu['route']); @endphp
                    <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                              {{ $active ? 'bg-cyan-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                        <x-dynamic-component :component="'icons.' . $menu['icon']" class="w-5 h-5" />
                        {{ $menu['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>