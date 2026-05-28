<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CalonJemaah;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Get the latest registered package if any
        $calonJemaah = $user->calonJemaahs()->with('jadwalKeberangkatan.paketHaji')->latest()->first();
        
        return view('pageuser.profil', compact('user', 'calonJemaah'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20|unique:users,no_wa,' . $user->id,
            'usia' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->no_wa = $request->no_wa;
        $user->usia = $request->usia;
        $user->jenis_kelamin = $request->jenis_kelamin;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profile')) {
            $request->validate([
                'foto_profile' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            $file = $request->file('foto_profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $filename);
            
            // Delete old photo if exists
            if ($user->foto_profile && file_exists(public_path($user->foto_profile))) {
                unlink(public_path($user->foto_profile));
            }
            
            $user->foto_profile = 'uploads/profil/' . $filename;
        }

        $user->save();

        Alert::success('Berhasil', 'Profil Anda berhasil diperbarui.');
        return back();
    }
}
