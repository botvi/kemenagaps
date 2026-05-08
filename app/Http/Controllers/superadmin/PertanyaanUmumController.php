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
        return view('pagesuperadmin.pertanyaan.index', compact('pertanyaanUmum'));
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

    public function show(PertanyaanUmum $pertanyaanUmum)
    {
        return view('pagesuperadmin.pertanyaan.show', compact('pertanyaanUmum'));
    }

    public function edit(PertanyaanUmum $pertanyaanUmum)
    {
        return view('pagesuperadmin.pertanyaan.edit', compact('pertanyaanUmum'));
    }

    public function update(Request $request, PertanyaanUmum $pertanyaanUmum)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        $pertanyaanUmum->update($data);

        Alert::success('Berhasil', 'Pertanyaan Umum berhasil diperbarui');
        return redirect()->route('pertanyaan.index');
    }

    public function destroy(PertanyaanUmum $pertanyaanUmum)
    {
        $pertanyaanUmum->delete();

        Alert::success('Berhasil', 'Pertanyaan Umum berhasil dihapus');
        return redirect()->route('pertanyaan.index');
    }
}
