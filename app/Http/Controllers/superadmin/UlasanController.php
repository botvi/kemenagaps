<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with('user')
            ->latest()
            ->paginate(10);

        return view('pagesuperadmin.ulasan.index', compact('ulasans'));
    }

    public function update(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'published' => 'required|boolean',
        ]);

        $ulasan->update([
            'published' => $request->published,
        ]);

        Alert::success('Berhasil', 'Status publikasi ulasan berhasil diperbarui.');
        return redirect()->route('ulasan.index');
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();

        Alert::success('Berhasil', 'Ulasan berhasil dihapus.');
        return redirect()->route('ulasan.index');
    }
}
