<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ActivationController extends Controller
{
    public function showActivationForm()
    {
        if (Auth::user()->is_active) {
            return redirect()->route('home');
        }
        return view('auth.activation');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'kode_login' => 'required',
        ]);

        $user = Auth::user();

        if ($user->kode_login === $request->kode_login) {
            $user->is_active = true;
            $user->save();
            
            Alert::success('Aktivasi Berhasil', 'Akun Anda telah diaktifkan!');
            return redirect()->route('home');
        }

        Alert::error('Aktivasi Gagal', 'Kode login yang Anda masukkan salah.');
        return back();
    }
}
