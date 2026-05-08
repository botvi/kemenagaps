<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\PaketHaji;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaketHajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paketHaji = PaketHaji::latest()->get();
        return view('pagesuperadmin.paket-haji.index', compact('paketHaji'));
    }

    public function create()
    {
        return view('pagesuperadmin.paket-haji.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'biaya_dp' => 'required|numeric',
            'durasi' => 'required',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        PaketHaji::create($data);

        Alert::success('Berhasil', 'Paket Haji berhasil ditambahkan');
        return redirect()->route('paket-haji.index');
    }

    public function show(PaketHaji $paketHaji)
    {
        return view('pagesuperadmin.paket-haji.show', compact('paketHaji'));
    }

    public function edit(PaketHaji $paketHaji)
    {
        return view('pagesuperadmin.paket-haji.edit', compact('paketHaji'));
    }

    public function update(Request $request, PaketHaji $paketHaji)
    {
        $request->validate([
            'nama_paket' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'biaya_dp' => 'required|numeric',
            'durasi' => 'required',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        $paketHaji->update($data);

        Alert::success('Berhasil', 'Paket Haji berhasil diperbarui');
        return redirect()->route('paket-haji.index');
    }

    public function destroy(PaketHaji $paketHaji)
    {
        $paketHaji->delete();

        Alert::success('Berhasil', 'Paket Haji berhasil dihapus');
        return redirect()->route('paket-haji.index');
    }
}
