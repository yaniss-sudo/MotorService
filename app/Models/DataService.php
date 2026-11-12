<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataService extends Model
{
    protected $fillable = ['id_servis', 'estimasi_service', 'nama_mekanik', 'sparepart_pengganti'];

    public function daftarService()
    {
        return $this->belongsTo(DaftarService::class, 'id_servis', 'id_servis');
    }
}
