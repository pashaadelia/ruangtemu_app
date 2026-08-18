<x-layouts.guest>
    <div class="p-10">
        <h1 class="text-2xl font-bold">Dashboard User</h1>
        <p>Selamat datang, {{ auth()->user()->name }}!</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Logout</button>
        </form>
    </div>
</x-layouts.guest>