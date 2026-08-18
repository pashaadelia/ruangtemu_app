<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruangan',
        'status_ruangan',
        'kapasitas',
        'deskripsi_fasilitas',
    ];

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_ruangan', 'id_ruangan', 'id_fasilitas');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_ruangan');
    }
}