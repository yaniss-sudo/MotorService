<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->string('no_plat', 15)->primary();
            $table->enum('jenis_kendaraan', ['Matic', 'Manual Transmisi']);
            $table->string('no_stnk', 50);
            $table->year('tahun_pembuatan');
            $table->string('nama_pemilik', 100);
            $table->string('warna', 50);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
