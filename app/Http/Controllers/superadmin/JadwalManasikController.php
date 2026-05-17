<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\JadwalManasik;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalManasikController extends Controller
{
    public function index()
    {
        $jadwalManasik = JadwalManasik::latest()->get();
        return view('pagesuperadmin.jadwal-manasik.index', compact('jadwalManasik'));
    }

    public function create()
    {
        return view('pagesuperadmin.jadwal-manasik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'pemateri' => 'required|string|max:255',
            'kuota_peserta' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
            'jenis_manasik' => 'nullable|string',
            'pertemuan_ke' => 'nullable|numeric',
        ]);

        JadwalManasik::create($request->all());

        Alert::success('Berhasil', 'Jadwal Manasik berhasil ditambahkan');
        return redirect()->route('jadwal-manasik.index');
    }

    public function edit(JadwalManasik $jadwalManasik)
    {
        return view('pagesuperadmin.jadwal-manasik.edit', compact('jadwalManasik'));
    }

    public function update(Request $request, JadwalManasik $jadwalManasik)
    {
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'pemateri' => 'required|string|max:255',
            'kuota_peserta' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
            'jenis_manasik' => 'nullable|string',
            'pertemuan_ke' => 'nullable|numeric',
        ]);

        $jadwalManasik->update($request->all());

        Alert::success('Berhasil', 'Jadwal Manasik berhasil diperbarui');
        return redirect()->route('jadwal-manasik.index');
    }

    public function destroy(JadwalManasik $jadwalManasik)
    {
        $jadwalManasik->delete();

        Alert::success('Berhasil', 'Jadwal Manasik berhasil dihapus');
        return redirect()->route('jadwal-manasik.index');
    }
}
