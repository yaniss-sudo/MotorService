<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * ID Pelanggan (pelanggans.id_pelanggan) dan ID Servis (daftar_services.id_servis)
 * tidak lagi dibuat otomatis oleh database, tetapi diisi manual oleh pengguna.
 *
 * Migration ini AMAN untuk data lama:
 *  - hanya melepas AUTO_INCREMENT, tipe kolom tetap BIGINT UNSIGNED
 *    (sama persis dengan kolom foreign key di tabel lain);
 *  - PRIMARY KEY tetap ada, sehingga ID tetap unik dan tidak boleh duplikat;
 *  - semua foreign key (daftar_services, data_services, pembayarans) tidak disentuh;
 *  - tidak ada data yang dihapus atau diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->ubah(autoIncrement: false);
    }

    public function down(): void
    {
        $this->ubah(autoIncrement: true);
    }

    private function ubah(bool $autoIncrement): void
    {
        // SQLite: kolom "integer primary key" sudah menerima ID manual, tidak perlu diubah.
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $extra = $autoIncrement ? ' AUTO_INCREMENT' : '';

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        try {
            DB::statement("ALTER TABLE `pelanggans` MODIFY `id_pelanggan` BIGINT UNSIGNED NOT NULL{$extra}");
            DB::statement("ALTER TABLE `daftar_services` MODIFY `id_servis` BIGINT UNSIGNED NOT NULL{$extra}");
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
};
