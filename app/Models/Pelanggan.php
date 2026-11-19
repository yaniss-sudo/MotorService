<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $primaryKey = 'id_pelanggan';

    // ID diisi manual oleh pengguna (bukan auto increment)
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id_pelanggan', 'nama_lengkap', 'no_hp', 'alamat', 'pekerjaan'];
}
