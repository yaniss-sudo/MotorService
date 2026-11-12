<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class DaftarServiceController extends Controller
{
    public function index()
    {
        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->get();
        return view('daftar_service.index', compact('daftarServices'));
    }

    public function create()
    {
        return view('daftar_service.create', [
            'kendaraans' => Kendaraan::orderBy('no_plat')->get(),
            'pelanggans' => Pelanggan::orderBy('id_pelanggan')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no_plat'        => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'   => 'required|exists:pelanggans,id_pelanggan',
            'keluhan'        => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        DaftarService::create($data);
        return redirect()->route('daftar-service.index')->with('success', 'Daftar service berhasil disimpan');
    }

    public function edit(DaftarService $daftarService)
    {
        return view('daftar_service.edit', [
            'daftarService' => $daftarService,
            'kendaraans'    => Kendaraan::orderBy('no_plat')->get(),
            'pelanggans'    => Pelanggan::orderBy('id_pelanggan')->get(),
        ]);
    }

    public function update(Request $request, DaftarService $daftarService)
    {
        $data = $request->validate([
            'no_plat'        => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'   => 'required|exists:pelanggans,id_pelanggan',
            'keluhan'        => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        $daftarService->update($data);
        return redirect()->route('daftar-service.index')->with('success', 'Daftar service berhasil diubah');
    }

    public function destroy(DaftarService $daftarService)
    {
        $daftarService->delete();
        return redirect()->route('daftar-service.index')->with('success', 'Daftar service berhasil dihapus');
    }
}
