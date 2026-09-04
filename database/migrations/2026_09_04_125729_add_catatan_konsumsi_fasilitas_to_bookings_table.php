<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('catatan_konsumsi')
                ->nullable()
                ->after('catatan');

            $table->text('catatan_fasilitas')
                ->nullable()
                ->after('catatan_konsumsi');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_konsumsi',
                'catatan_fasilitas'
            ]);
        });
    }
};