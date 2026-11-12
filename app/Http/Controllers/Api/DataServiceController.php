<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataService;
use Illuminate\Http\Request;

class DataServiceController extends Controller
{
    private function rules(): array
    {
        return [
            'id_servis'           => 'required|exists:daftar_services,id_servis',
            'estimasi_service'    => 'required|string|max:100',
            'nama_mekanik'        => 'required|string|max:100',
            'sparepart_pengganti' => 'nullable|string',
        ];
    }

    private function notFound()
    {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => DataService::with('daftarService:id_servis,keluhan')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = DataService::create($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $data->load('daftarService')], 201);
    }

    public function show(string $id)
    {
        $data = DataService::with('daftarService')->find($id);
        return $data
            ? response()->json(['success' => true, 'data' => $data])
            : $this->notFound();
    }

    public function update(Request $request, string $id)
    {
        $data = DataService::find($id);
        if (!$data) {
            return $this->notFound();
        }
        $data->update($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $data->load('daftarService')]);
    }

    public function destroy(string $id)
    {
        $data = DataService::find($id);
        if (!$data) {
            return $this->notFound();
        }
        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
