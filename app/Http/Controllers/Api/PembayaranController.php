<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    private function rules(): array
    {
        return [
            'id_servis'        => 'required|exists:daftar_services,id_servis',
            'jumlah_biaya'     => 'required|integer|min:0',
            'jenis_pembayaran' => 'required|in:Cash / Tunai,Non Tunai',
            'keterangan'       => 'nullable|string',
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
            'data'    => Pembayaran::with('daftarService:id_servis,keluhan')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = Pembayaran::create($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $data->load('daftarService')], 201);
    }

    public function show(string $id)
    {
        $data = Pembayaran::with('daftarService')->find($id);
        return $data
            ? response()->json(['success' => true, 'data' => $data])
            : $this->notFound();
    }

    public function update(Request $request, string $id)
    {
        $data = Pembayaran::find($id);
        if (!$data) {
            return $this->notFound();
        }
        $data->update($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $data->load('daftarService')]);
    }

    public function destroy(string $id)
    {
        $data = Pembayaran::find($id);
        if (!$data) {
            return $this->notFound();
        }
        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
