<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanBelumTerjawab;
use App\Models\PertanyaanUmum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PertanyaanBelumTerjawabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('pertanyaan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = PertanyaanBelumTerjawab::findOrFail($id);
        return view('pagesuperadmin.pertanyaan.jawab', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required',
        ], [
            'jawaban.required' => 'Jawaban wajib diisi',
        ]);

        $unanswered = PertanyaanBelumTerjawab::findOrFail($id);

        // Tambahkan ke daftar Pertanyaan Umum (FAQ)
        $maxUrutan = PertanyaanUmum::max('urutan') ?? 0;
        PertanyaanUmum::create([
            'pertanyaan' => $unanswered->pertanyaan,
            'jawaban' => $request->jawaban,
            'urutan' => $maxUrutan + 1,
            'published' => true,
        ]);

        // Hapus dari daftar belum terjawab
        $unanswered->delete();

        Alert::success('Berhasil', 'Pertanyaan berhasil dijawab dan disimpan ke Pertanyaan Umum');
        return redirect()->route('pertanyaan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unanswered = PertanyaanBelumTerjawab::findOrFail($id);
        $unanswered->delete();

        Alert::success('Berhasil', 'Pertanyaan berhasil diabaikan/dihapus');
        return redirect()->route('pertanyaan.index');
    }
}
