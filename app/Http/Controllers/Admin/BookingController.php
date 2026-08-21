<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Divisi;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $ruangans = Ruangan::with('fasilitas')->orderBy('nama_ruangan')->get();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        $timeSlots = $this->generateTimeSlots();

        return view('admin.booking.create', compact('ruangans', 'divisis', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rapat' => 'required|string|max:255',
            'tujuan_rapat' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required|after:jam_masuk',
            'id_ruangan' => 'required|exists:ruangans,id',
            'id_divisi' => 'required|exists:divisis,id',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'nama_tamu' => 'nullable|string|max:255',
            'total_peserta' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        // Cek bentrok jadwal di ruangan & tanggal yang sama
        $bentrok = Booking::where('id_ruangan', $validated['id_ruangan'])
            ->where('tanggal', $validated['tanggal'])
            ->whereIn('status_booking', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_masuk', [$validated['jam_masuk'], $validated['jam_keluar']])
                  ->orWhereBetween('jam_keluar', [$validated['jam_masuk'], $validated['jam_keluar']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_masuk', '<=', $validated['jam_masuk'])
                         ->where('jam_keluar', '>=', $validated['jam_keluar']);
                  });
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_masuk' => 'Ruangan sudah dibooking pada rentang waktu tersebut.'])->withInput();
        }

        // Cek kapasitas ruangan
        $ruangan = Ruangan::findOrFail($validated['id_ruangan']);
        if ($validated['total_peserta'] > $ruangan->kapasitas) {
            return back()->withErrors(['total_peserta' => "Total peserta melebihi kapasitas ruangan ({$ruangan->kapasitas} orang)."])->withInput();
        }

        $validated['status_booking'] = 0;

        Booking::create($validated);

        return redirect()->route('admin.jadwal.hari-ini')->with('status', 'Booking rapat berhasil disimpan.');
    }
    
        /**
     * Form Edit Ruang Rapat
     */
    public function edit(Booking $booking)
    {
        $ruangans = Ruangan::with('fasilitas')->orderBy('nama_ruangan')->get();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        $timeSlots = $this->generateTimeSlots();

        return view('admin.booking.edit', compact('booking', 'ruangans', 'divisis', 'timeSlots'));
    }

    /**
     * Simpan perubahan booking
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'nama_rapat' => 'required|string|max:255',
            'tujuan_rapat' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required|after:jam_masuk',
            'id_ruangan' => 'required|exists:ruangans,id',
            'id_divisi' => 'required|exists:divisis,id',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'nama_tamu' => 'nullable|string|max:255',
            'total_peserta' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'status_booking' => 'required|in:menunggu,disetujui,berlangsung,selesai,dibatalkan',
        ]);

        // Cek bentrok jadwal, kecualikan booking ini sendiri
        $bentrok = Booking::where('id_ruangan', $validated['id_ruangan'])
            ->where('tanggal', $validated['tanggal'])
            ->where('id', '!=', $booking->id)
            ->whereIn('status_booking', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_masuk', [$validated['jam_masuk'], $validated['jam_keluar']])
                  ->orWhereBetween('jam_keluar', [$validated['jam_masuk'], $validated['jam_keluar']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_masuk', '<=', $validated['jam_masuk'])
                         ->where('jam_keluar', '>=', $validated['jam_keluar']);
                  });
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_masuk' => 'Ruangan sudah dibooking pada rentang waktu tersebut.'])->withInput();
        }

        // Cek kapasitas ruangan
        $ruangan = Ruangan::findOrFail($validated['id_ruangan']);
        if ($validated['total_peserta'] > $ruangan->kapasitas) {
            return back()->withErrors(['total_peserta' => "Total peserta melebihi kapasitas ruangan ({$ruangan->kapasitas} orang)."])->withInput();
        }

        $booking->update($validated);

        return redirect()->route('admin.jadwal.hari-ini')->with('status', 'Booking rapat berhasil diperbarui.');
    }

    /**
     * Endpoint AJAX: cek jam yang sudah terisi untuk ruangan & tanggal tertentu
     */
    public function availability(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
             'exclude_id' => 'nullable|exists:bookings,id',
        ]);

          $query = Booking::where('id_ruangan', $request->id_ruangan)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status_booking', ['menunggu', 'disetujui']);
 
        if ($request->filled('exclude_id')) {
            $query->where('id', '!=', $request->exclude_id);
        }
        
        $bookings = Booking::where('id_ruangan', $request->id_ruangan)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status_booking', ['menunggu', 'disetujui'])
            ->get(['jam_masuk', 'jam_keluar']);

        $terisi = [];
        foreach ($bookings as $b) {
            $start = Carbon::parse($b->jam_masuk);
            $end = Carbon::parse($b->jam_keluar);
            while ($start->lt($end)) {
                $terisi[] = $start->format('H:i');
                $start->addMinutes(30);
            }
        }

        return response()->json(['terisi' => array_unique($terisi)]);
    }

    private function generateTimeSlots(): array
    {
        $slots = [];
        $start = Carbon::createFromTime(8, 0);
        $end = Carbon::createFromTime(20, 0);

        while ($start->lte($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return $slots;
    }
}