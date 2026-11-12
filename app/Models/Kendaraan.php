<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $primaryKey = 'no_plat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $appends = ['foto_url'];

    protected $fillable = [
        'no_plat', 'jenis_kendaraan', 'no_stnk',
        'tahun_pembuatan', 'nama_pemilik', 'warna', 'foto',
    ];

    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->foto ? asset('storage/' . $this->foto) : null
        );
    }
}
