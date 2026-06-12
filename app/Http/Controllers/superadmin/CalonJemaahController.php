<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\User;
use App\Models\PaketHaji;

class CalonJemaahController extends Controller
{
    public function index()
    {
        $calonJemaah = CalonJemaah::with(['user', 'paketHaji'])->latest()->get();
        return view('pagesuperadmin.calon-jemaah.index', compact('calonJemaah'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $paketHaji = PaketHaji::all();
        return view('pagesuperadmin.calon-jemaah.create', compact('users', 'paketHaji'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahun_pendaftaran' => 'required',
            'paket_haji_id' => 'required|exists:paket_hajis,id',
            'kodelogin' => 'required|unique:calon_jemaahs,kodelogin',
        ]);

        $data = $request->all();
        if (empty($data['status_pendaftaran'])) {
            $data['status_pendaftaran'] = 'dikonfirmasi';
        }

        CalonJemaah::create($data);

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
        $paketHaji = PaketHaji::all();
        return view('pagesuperadmin.calon-jemaah.edit', compact('calonJemaah', 'users', 'paketHaji'));
    }

    public function update(Request $request, CalonJemaah $calonJemaah)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahun_pendaftaran' => 'required',
            'paket_haji_id' => 'required|exists:paket_hajis,id',
            'kodelogin' => 'required|unique:calon_jemaahs,kodelogin,' . $calonJemaah->id,
        ]);

        $data = $request->all();
        if (empty($data['status_pendaftaran'])) {
            $data['status_pendaftaran'] = 'dikonfirmasi';
        }

        $calonJemaah->update($data);

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
