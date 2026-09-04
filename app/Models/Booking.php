<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama_rapat',
        'tujuan_rapat',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'id_ruangan',
        'id_divisi',
        'nama_penanggung_jawab',
        'nama_tamu',
        'total_peserta',
        'catatan_konsumsi',
        'catatan_fasilitas',
        'informasi_tambahan',
        'status_booking',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    /**
     * Status yang ditampilkan ke user, dihitung otomatis dari jam rapat
     * dibanding waktu sekarang. "Dibatalkan" (status_booking = 1) selalu
     * menang apapun waktunya.
     */
    public function getComputedStatusAttribute(): array
    {
        if ((int) $this->status_booking === 1) {
            return [
                'key'   => 'dibatalkan',
                'label' => 'Dibatalkan',
                'class' => 'bg-red-100 text-red-700',
            ];
        }

        $tanggal = Carbon::parse($this->tanggal)->format('Y-m-d');
        $mulai   = Carbon::parse($tanggal . ' ' . Carbon::parse($this->jam_masuk)->format('H:i:s'));
        $selesai = Carbon::parse($tanggal . ' ' . Carbon::parse($this->jam_keluar)->format('H:i:s'));
        $now     = Carbon::now();

        if ($now->lt($mulai)) {
            return [
                'key'   => 'belum_mulai',
                'label' => 'Booking',
                'class' => 'bg-slate-100 text-slate-500',
            ];
        }

        if ($now->between($mulai, $selesai)) {
            return [
                'key'   => 'berlangsung',
                'label' => 'Sedang Berlangsung',
                'class' => 'bg-blue-100 text-blue-700',
            ];
        }

        return [
            'key'   => 'selesai',
            'label' => 'Selesai',
            'class' => 'bg-green-100 text-green-700',
        ];
    }
}
