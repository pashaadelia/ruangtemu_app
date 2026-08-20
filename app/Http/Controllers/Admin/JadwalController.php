<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Halaman Jadwal Ruangan (kalender bulanan) - untuk sidebar
     */
    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);

        $current = Carbon::createFromDate($year, $month, 1);
        $startOfMonth = $current->copy()->startOfMonth();
        $endOfMonth = $current->copy()->endOfMonth();

        // Ambil semua booking di bulan ini, dikelompokkan per tanggal
        $bookings = Booking::with('ruangan')
            ->whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orderBy('jam_masuk')
            ->get()
            ->groupBy(fn ($b) => Carbon::parse($b->tanggal)->format('Y-m-d'));

        // Bangun struktur kalender (6 baris x 7 kolom, Senin-Minggu)
        $startDay = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endDay = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $weeks = [];
        $week = [];
        $day = $startDay->copy();

        while ($day->lte($endDay)) {
            $dateKey = $day->format('Y-m-d');
            $week[] = [
                'date' => $day->copy(),
                'inMonth' => $day->month === $current->month,
                'isToday' => $day->isToday(),
                'bookings' => $bookings->get($dateKey, collect()),
            ];

            if ($day->dayOfWeekIso === 7) {
                $weeks[] = $week;
                $week = [];
            }

            $day->addDay();
        }

        return view('admin.jadwal', [
            'weeks' => $weeks,
            'current' => $current,
            'prevMonth' => $current->copy()->subMonth(),
            'nextMonth' => $current->copy()->addMonth(),
        ]);
    }

    /**
     * Halaman "Jadwal Hari Ini" (Lihat Semua dari dashboard) - standalone, tanpa sidebar
     */
    public function hariIni(Request $request)
    {
        $query = Booking::with('ruangan')
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_rapat', 'like', "%{$search}%")
                  ->orWhereHas('ruangan', function ($q2) use ($search) {
                      $q2->where('nama_ruangan', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        $jadwal = $query->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('admin.jadwal-hari-ini', compact('jadwal', 'ruangans'));
    }

    public function show($id)
    {
        $booking = Booking::with(['ruangan.fasilitas', 'divisi'])->findOrFail($id);

        return view('admin.detail-rapat', compact('booking'));
    }
}