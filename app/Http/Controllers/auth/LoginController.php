<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
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
                Alert::success('Login Mantap!', 'Welcome back, Superadmin! Siap-siap ngatur dunia 😎');
                return redirect()->route('dashboard-superadmin');
            } else if ($user->role == 'user') {
                if (!$user->is_active) {
                    Alert::info('Aktivasi Akun', 'Silakan masukkan kode login yang diberikan oleh admin.');
                    return redirect()->route('activation.form');
                }
                Alert::success('Login Mantap!', 'Halo bro, selamat datang lagi di Linkskuy!');
                return redirect()->route('home');
            } else {
                Auth::logout();
                Alert::error('Login Failed', 'Kamu gak punya akses ke area ini, bro!');
                return redirect('/login');
            }
        }
    
        Alert::error('Login Failed', 'Username atau password kamu salah, bro!');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Yah, cabut dulu ya?', 'Logout sukses, jangan lupa balik lagi bro!');
        return redirect('/');
    }
}
