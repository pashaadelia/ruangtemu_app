<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class PengaturanController extends Controller
{
    /**
     * Tampilkan halaman Pengaturan.
     */
    public function index(Request $request)
    {
        return view('admin.pengaturan', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui data profil (nama, email, foto).
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'foto_profil'  => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('public/foto-profil');
            $validated['foto_profil'] = Storage::url($path);
        } else {
            unset($validated['foto_profil']);
        }

        $user->update($validated);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi pengguna.
     */
    public function updateKeamanan(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'          => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Kata sandi berhasil diperbarui.');
    }
}