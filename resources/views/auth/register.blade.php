<x-layouts.guest>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
            <h1 class="text-xl font-bold text-cyan-700 text-center mb-6">Daftar Akun</h1>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm rounded-lg p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <button type="submit"
                        class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2.5 rounded-lg transition">
                    Daftar
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4">
                Sudah punya akun? <a href="{{ route('login', 'user') }}" class="text-cyan-600 hover:underline">Login</a>
            </p>
        </div>
    </div>
</x-layouts.guest>