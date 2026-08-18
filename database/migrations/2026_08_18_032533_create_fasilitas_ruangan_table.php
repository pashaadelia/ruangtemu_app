<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ruangan')->constrained('ruangans')->onDelete('cascade');
            $table->foreignId('id_fasilitas')->constrained('fasilitas')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_ruangan', 'id_fasilitas']); // cegah duplikat pasangan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_ruangan');
    }
};