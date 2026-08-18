<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    public function ruangans()
    {
        return $this->belongsToMany(Ruangan::class, 'fasilitas_ruangan', 'id_fasilitas', 'id_ruangan');
    }
}
