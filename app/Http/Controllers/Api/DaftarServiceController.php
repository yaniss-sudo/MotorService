<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class DaftarServiceController extends Controller
{
    private function rules(): array
    {
        return [
            'no_plat'        => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'   => 'required|exists:pelanggans,id_pelanggan',
            'keluhan'        => 'required|string',
            'tanggal_servis' => 'required|date',
        ];
    }

    private function notFound()
    {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    public function index()
    {
        $data = DaftarService::with(['pelanggan:id_pelanggan,nama_lengkap', 'kendaraan:no_plat,jenis_kendaraan'])
            ->latest()->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $service = DaftarService::create($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $service->load('pelanggan', 'kendaraan')], 201);
    }

    public function show(string $id)
    {
        $service = DaftarService::with('pelanggan', 'kendaraan')->find($id);
        return $service
            ? response()->json(['success' => true, 'data' => $service])
            : $this->notFound();
    }

    public function update(Request $request, string $id)
    {
        $service = DaftarService::find($id);
        if (!$service) {
            return $this->notFound();
        }
        $service->update($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $service->load('pelanggan', 'kendaraan')]);
    }

    public function destroy(string $id)
    {
        $service = DaftarService::find($id);
        if (!$service) {
            return $this->notFound();
        }
        $service->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
