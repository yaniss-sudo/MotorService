<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return view('pelanggan.index', ['pelanggans' => Pelanggan::latest()->get()]);
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'alamat'       => 'required|string',
            'pekerjaan'    => 'required|string|max:100',
        ]);

        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil disimpan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'alamat'       => 'required|string',
            'pekerjaan'    => 'required|string|max:100',
        ]);

        $pelanggan->update($data);
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diubah');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus');
    }
}
