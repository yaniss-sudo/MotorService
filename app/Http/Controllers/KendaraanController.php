<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    /**
     * Aturan validasi. No plat hanya divalidasi saat tambah data,
     * karena no plat adalah primary key dan tidak diubah saat edit.
     */
    private function rules(bool $isCreate = true): array
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

    public function index()
    {
        return view('kendaraan.index', [
            'kendaraans' => Kendaraan::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true));

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        Kendaraan::create($data);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil disimpan');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate($this->rules(false));

        if ($request->hasFile('foto')) {
            // Hapus foto lama agar tidak menumpuk di storage
            if ($kendaraan->foto) {
                Storage::disk('public')->delete($kendaraan->foto);
            }
            $data['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        $kendaraan->update($data);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diubah');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        if ($kendaraan->foto) {
            Storage::disk('public')->delete($kendaraan->foto);
        }

        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil dihapus');
    }
}
