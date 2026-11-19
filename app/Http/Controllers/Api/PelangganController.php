<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:100',
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'alamat'       => 'required|string',
            'pekerjaan'    => 'required|string|max:100',
        ];
    }

    public function index()
    {
        return response()->json(['success' => true, 'data' => Pelanggan::latest()->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            ['id_pelanggan' => 'required|integer|min:1|max:2147483647|unique:pelanggans,id_pelanggan']
            + $this->rules(),
            ['id_pelanggan.unique' => 'ID Pelanggan sudah digunakan, gunakan ID lain.']
        );
        $pelanggan = Pelanggan::create($data);
        return response()->json(['success' => true, 'data' => $pelanggan], 201);
    }

    public function show(string $id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $pelanggan]);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $pelanggan->update($request->validate($this->rules()));
        return response()->json(['success' => true, 'data' => $pelanggan]);
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $pelanggan->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
