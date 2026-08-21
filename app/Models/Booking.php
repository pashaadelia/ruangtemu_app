<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama_rapat', 'tujuan_rapat', 'tanggal', 'jam_masuk', 'jam_keluar',
        'id_ruangan', 'id_divisi', 'nama_penanggung_jawab', 'nama_tamu',
        'total_peserta', 'catatan', 'informasi_tambahan', 'status_booking',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }
}