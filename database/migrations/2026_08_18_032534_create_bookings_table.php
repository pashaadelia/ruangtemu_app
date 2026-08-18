<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rapat');
            $table->text('tujuan_rapat')->nullable();
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->foreignId('id_ruangan')->constrained('ruangans')->onDelete('cascade');
            $table->foreignId('id_divisi')->constrained('divisis')->onDelete('cascade');
            $table->string('nama_penanggung_jawab');
            $table->string('nama_tamu')->nullable();
            $table->integer('total_peserta');
            $table->text('catatan')->nullable();
            $table->tinyInteger('status_booking')->default(0); // 0=menunggu,1=disetujui,2=ditolak,3=selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};