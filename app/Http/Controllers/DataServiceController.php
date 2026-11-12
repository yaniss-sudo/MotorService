<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
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

    public function index()
    {
        $dataServices = DataService::with('daftarService')->latest()->get();
        return view('data_service.index', compact('dataServices'));
    }

    public function create()
    {
        return view('data_service.create', ['daftarServices' => DaftarService::orderBy('id_servis')->get()]);
    }

    public function store(Request $request)
    {
        DataService::create($request->validate($this->rules()));
        return redirect()->route('data-service.index')->with('success', 'Data service berhasil disimpan');
    }

    public function edit(DataService $dataService)
    {
        return view('data_service.edit', [
            'dataService'    => $dataService,
            'daftarServices' => DaftarService::orderBy('id_servis')->get(),
        ]);
    }

    public function update(Request $request, DataService $dataService)
    {
        $dataService->update($request->validate($this->rules()));
        return redirect()->route('data-service.index')->with('success', 'Data service berhasil diubah');
    }

    public function destroy(DataService $dataService)
    {
        $dataService->delete();
        return redirect()->route('data-service.index')->with('success', 'Data service berhasil dihapus');
    }
}
