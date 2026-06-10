<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanUmum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PertanyaanUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pertanyaanUmum = PertanyaanUmum::orderBy('urutan')->get();
        $pertanyaanBelumTerjawab = \App\Models\PertanyaanBelumTerjawab::orderBy('jumlah_ditanyakan', 'desc')->latest()->get();
        return view('pagesuperadmin.pertanyaan.index', compact('pertanyaanUmum', 'pertanyaanBelumTerjawab'));
    }

    public function create()
    {
        return view('pagesuperadmin.pertanyaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        PertanyaanUmum::create($data);

        Alert::success('Berhasil', 'Pertanyaan Umum berhasil ditambahkan');
        return redirect()->route('pertanyaan.index');
    }

    public function show(PertanyaanUmum $pertanyaan)
    {
        $pertanyaanUmum = $pertanyaan;
        return view('pagesuperadmin.pertanyaan.show', compact('pertanyaanUmum'));
    }

    public function edit(PertanyaanUmum $pertanyaan)
    {
        $pertanyaanUmum = $pertanyaan;
        return view('pagesuperadmin.pertanyaan.edit', compact('pertanyaanUmum'));
    }

    public function update(Request $request, PertanyaanUmum $pertanyaan)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        $pertanyaan->update($data);

        Alert::success('Berhasil', 'Pertanyaan Umum berhasil diperbarui');
        return redirect()->route('pertanyaan.index');
    }

    public function destroy(PertanyaanUmum $pertanyaan)
    {
        $pertanyaan->delete();

        Alert::success('Berhasil', 'Pertanyaan Umum berhasil dihapus');
        return redirect()->route('pertanyaan.index');
    }
}
