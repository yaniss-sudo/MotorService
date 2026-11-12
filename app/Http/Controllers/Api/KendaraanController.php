<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    private function rules(bool $isCreate): array
    {
        $rules = [
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk'         => 'required|string|max:50',
            'tahun_pembuatan' => 'required|integer|between:1980,' . date('Y'),
            'nama_pemilik'    => 'required|string|max:100',
            'warna'           => 'required|string|max:50',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
        if ($isCreate) {
            $rules['no_plat'] = 'required|string|max:15|unique:kendaraans,no_plat';
        }
        return $rules;
    }

    private function notFound()
    {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    public function index()
    {
        return response()->json(['success' => true, 'data' => Kendaraan::latest()->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true));

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        $kendaraan = Kendaraan::create($data);
        return response()->json(['success' => true, 'data' => $kendaraan->fresh()], 201);
    }

    public function show(string $id)
    {
        $kendaraan = Kendaraan::find($id);
        return $kendaraan
            ? response()->json(['success' => true, 'data' => $kendaraan])
            : $this->notFound();
    }

    public function update(Request $request, string $id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return $this->notFound();
        }

        $data = $request->validate($this->rules(false));

        if ($request->hasFile('foto')) {
            if ($kendaraan->foto) {
                Storage::disk('public')->delete($kendaraan->foto);
            }
            $data['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        $kendaraan->update($data);
        return response()->json(['success' => true, 'data' => $kendaraan->fresh()]);
    }

    public function destroy(string $id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return $this->notFound();
        }

        if ($kendaraan->foto) {
            Storage::disk('public')->delete($kendaraan->foto);
        }
        $kendaraan->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
