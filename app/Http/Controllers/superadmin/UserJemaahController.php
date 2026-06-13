<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class UserJemaahController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('pagesuperadmin.user-jemaah.index', compact('users'));
    }

    public function generateCode(User $user)
    {
        $user->kode_login = strtoupper(Str::random(6));
        $user->save();
        Alert::success('Berhasil', 'Kode login berhasil diganti');
        return back();
    }
    
    public function activate(User $user)
    {
        $user->is_active = true;
        $user->save();
        Alert::success('Berhasil', 'Akun user berhasil diaktifkan');
        return back();
    }

    public function updateStatus(User $user, Request $request)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $user->status = $request->status;
        $user->save();
        
        Alert::success('Berhasil', 'Status akun jemaah berhasil diperbarui.');
        return back();
    }
}
