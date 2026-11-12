<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
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

    public function index()
    {
        $pembayarans = Pembayaran::with('daftarService')->latest()->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        return view('pembayaran.create', ['daftarServices' => DaftarService::orderBy('id_servis')->get()]);
    }

    public function store(Request $request)
    {
        Pembayaran::create($request->validate($this->rules()));
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil disimpan');
    }

    public function edit(Pembayaran $pembayaran)
    {
        return view('pembayaran.edit', [
            'pembayaran'     => $pembayaran,
            'daftarServices' => DaftarService::orderBy('id_servis')->get(),
        ]);
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $pembayaran->update($request->validate($this->rules()));
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diubah');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus');
    }
}
