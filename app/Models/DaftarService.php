<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarService extends Model
{
    protected $primaryKey = 'id_servis';

    // ID diisi manual oleh pengguna (bukan auto increment)
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id_servis', 'no_plat', 'id_pelanggan', 'keluhan', 'tanggal_servis'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'no_plat', 'no_plat');
    }
}
