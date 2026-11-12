<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_services', function (Blueprint $table) {
            $table->id('id_servis');
            $table->string('no_plat', 15);
            $table->unsignedBigInteger('id_pelanggan');
            $table->text('keluhan');
            $table->date('tanggal_servis');
            $table->timestamps();

            $table->foreign('no_plat')->references('no_plat')->on('kendaraans')
                  ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')
                  ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_services');
    }
};
