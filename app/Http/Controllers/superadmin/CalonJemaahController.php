<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\User;
use App\Models\JadwalKeberangkatan;

class CalonJemaahController extends Controller
{
    public function index()
    {
        $calonJemaah = CalonJemaah::with(['user', 'jadwalKeberangkatan.paketHaji'])->latest()->get();
        return view('pagesuperadmin.calon-jemaah.index', compact('calonJemaah'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $jadwalKeberangkatan = JadwalKeberangkatan::with('paketHaji')->where('is_active', true)->get();
        return view('pagesuperadmin.calon-jemaah.create', compact('users', 'jadwalKeberangkatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_keberangkatan_id' => 'required|exists:jadwal_keberangkatans,id',
            'status_pendaftaran' => 'required',
            'kodelogin' => 'required|unique:calon_jemaahs,kodelogin',
        ]);

        CalonJemaah::create($request->all());

        Alert::success('Berhasil', 'Calon Jemaah berhasil ditambahkan');
        return redirect()->route('calon-jemaah.index');
    }

    public function show(CalonJemaah $calonJemaah)
    {
        return view('pagesuperadmin.calon-jemaah.show', compact('calonJemaah'));
    }

    public function edit(CalonJemaah $calonJemaah)
    {
        $users = User::where('role', 'user')->get();
        $jadwalKeberangkatan = JadwalKeberangkatan::with('paketHaji')->where('is_active', true)->get();
        return view('pagesuperadmin.calon-jemaah.edit', compact('calonJemaah', 'users', 'jadwalKeberangkatan'));
    }

    public function update(Request $request, CalonJemaah $calonJemaah)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_keberangkatan_id' => 'required|exists:jadwal_keberangkatans,id',
            'status_pendaftaran' => 'required',
            'kodelogin' => 'required|unique:calon_jemaahs,kodelogin,' . $calonJemaah->id,
        ]);

        $calonJemaah->update($request->all());

        Alert::success('Berhasil', 'Calon Jemaah berhasil diperbarui');
        return redirect()->route('calon-jemaah.index');
    }

    public function destroy(CalonJemaah $calonJemaah)
    {
        $calonJemaah->delete();

        Alert::success('Berhasil', 'Calon Jemaah berhasil dihapus');
        return redirect()->route('calon-jemaah.index');
    }
}
