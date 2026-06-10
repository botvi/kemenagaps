<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;

        // Coba login dengan username atau email
        $credentials = [
            'password' => $password
        ];

        // Jika input mengandung @, anggap sebagai email
        if (strpos($username, '@') !== false) {
            $credentials['email'] = $username;
        } else {
            $credentials['username'] = $username;
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'superadmin') {
                Alert::success('Login Berhasil', 'Selamat datang kembali, Superadmin.');
                return redirect()->route('dashboard-superadmin');
            } else if ($user->role == 'user') {
                if (!$user->is_active) {
                    Alert::info('Aktivasi Akun', 'Silakan masukkan kode login yang diberikan oleh admin.');
                    return redirect()->route('activation.form', $user->id);
                }
                // Cek apakah user sudah terdaftar sebagai calon jemaah
                $isCalonJemaah = CalonJemaah::where('user_id', $user->id)->exists();
                if ($isCalonJemaah) {
                    Alert::success('Login Berhasil', 'Selamat datang kembali, Jemaah.');
                    return redirect()->route('jemaah.dashboard');
                }
                Alert::success('Login Berhasil', 'Selamat datang kembali di Kemenhaj Kuansing.');
                return redirect()->route('home');
            } else {
                Auth::logout();
                Alert::error('Akses Ditolak', 'Anda tidak memiliki wewenang untuk mengakses halaman ini.');
                return redirect('/login');
            }
        }

        Alert::error('Login Gagal', 'Username atau password yang Anda masukkan salah.');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Logout Berhasil', 'Anda telah berhasil keluar dari sistem.');
        return redirect('/');
    }
}
