<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_servis');
            $table->unsignedBigInteger('jumlah_biaya');
            $table->enum('jenis_pembayaran', ['Cash / Tunai', 'Non Tunai']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_servis')->references('id_servis')->on('daftar_services')
                  ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
