<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKeberangkatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\PaketHaji;

class JadwalKeberangkatanController extends Controller
{
    public function index()
    {
        $jadwalKeberangkatan = JadwalKeberangkatan::with('paketHaji')->latest()->get();
        return view('pagesuperadmin.jadwal-keberangkatan.index', compact('jadwalKeberangkatan'));
    }

    public function create()
    {
        $paketHaji = PaketHaji::where('published', true)->get();
        return view('pagesuperadmin.jadwal-keberangkatan.create', compact('paketHaji'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_haji_id' => 'required|exists:paket_hajis,id',
            'tanggal_keberangkatan' => 'required|date',
            'kuota' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        JadwalKeberangkatan::create($data);

        Alert::success('Berhasil', 'Jadwal Keberangkatan berhasil ditambahkan');
        return redirect()->route('jadwal-keberangkatan.index');
    }

    public function show(JadwalKeberangkatan $jadwalKeberangkatan)
    {
        return view('pagesuperadmin.jadwal-keberangkatan.show', compact('jadwalKeberangkatan'));
    }

    public function edit(JadwalKeberangkatan $jadwalKeberangkatan)
    {
        $paketHaji = PaketHaji::where('published', true)->get();
        return view('pagesuperadmin.jadwal-keberangkatan.edit', compact('jadwalKeberangkatan', 'paketHaji'));
    }

    public function update(Request $request, JadwalKeberangkatan $jadwalKeberangkatan)
    {
        $request->validate([
            'paket_haji_id' => 'required|exists:paket_hajis,id',
            'tanggal_keberangkatan' => 'required|date',
            'kuota' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $jadwalKeberangkatan->update($data);

        Alert::success('Berhasil', 'Jadwal Keberangkatan berhasil diperbarui');
        return redirect()->route('jadwal-keberangkatan.index');
    }

    public function destroy(JadwalKeberangkatan $jadwalKeberangkatan)
    {
        $jadwalKeberangkatan->delete();

        Alert::success('Berhasil', 'Jadwal Keberangkatan berhasil dihapus');
        return redirect()->route('jadwal-keberangkatan.index');
    }
}
