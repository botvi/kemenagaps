<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Informasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informasi = Informasi::latest()->get();
        return view('pagesuperadmin.informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('pagesuperadmin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'konten' => 'required',
            'tanggal_terbit' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $imageName = time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('images/informasi'), $imageName);
            $data['thumbnail'] = $imageName;
        }

        $data['published'] = $request->has('published');

        Informasi::create($data);

        Alert::success('Berhasil', 'Informasi berhasil ditambahkan');
        return redirect()->route('informasi.index');
    }

    public function show(Informasi $informasi)
    {
        return view('pagesuperadmin.informasi.show', compact('informasi'));
    }

    public function edit(Informasi $informasi)
    {
        return view('pagesuperadmin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, Informasi $informasi)
    {
        $request->validate([
            'judul' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'konten' => 'required',
            'tanggal_terbit' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            // Delete old image if exists
            if ($informasi->thumbnail && file_exists(public_path('images/informasi/' . $informasi->thumbnail))) {
                unlink(public_path('images/informasi/' . $informasi->thumbnail));
            }

            $imageName = time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('images/informasi'), $imageName);
            $data['thumbnail'] = $imageName;
        }

        $data['published'] = $request->has('published');

        $informasi->update($data);

        Alert::success('Berhasil', 'Informasi berhasil diperbarui');
        return redirect()->route('informasi.index');
    }

    public function destroy(Informasi $informasi)
    {
        if ($informasi->thumbnail && file_exists(public_path('images/informasi/' . $informasi->thumbnail))) {
            unlink(public_path('images/informasi/' . $informasi->thumbnail));
        }

        $informasi->delete();

        Alert::success('Berhasil', 'Informasi berhasil dihapus');
        return redirect()->route('informasi.index');
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/informasi'), $filename);

            return response()->json([
                'location' => asset('uploads/informasi/' . $filename)
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
