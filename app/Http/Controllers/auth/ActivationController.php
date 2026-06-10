<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ActivationController extends Controller
{
    public function showActivationForm($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_active) {
            // Jika user sudah aktif dan sudah login
            if (Auth::check() && Auth::id() == $id) {
                return redirect()->route('home');
            }
            Alert::info('Akun Sudah Aktif', 'Akun Anda sudah aktif. Silakan masuk.');
            return redirect()->route('login');
        }

        return view('auth.activation', compact('user'));
    }

    public function activate(Request $request, $id)
    {
        $request->validate([
            'kode_login' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        if ($user->is_active) {
            Alert::info('Akun Sudah Aktif', 'Akun Anda sudah aktif. Silakan masuk.');
            return redirect()->route('login');
        }

        if (strtoupper($user->kode_login) === strtoupper($request->kode_login)) {
            $user->is_active = true;
            $user->save();
            
            // Login otomatis setelah aktivasi berhasil
            Auth::login($user);
            
            Alert::success('Aktivasi Berhasil', 'Akun Anda telah diaktifkan!');
            return redirect()->route('home');
        }

        Alert::error('Aktivasi Gagal', 'Kode aktivasi yang Anda masukkan salah.');
        return back();
    }

    public function revealCode(Request $request, $id)
    {
        $request->validate([
            'h-captcha-response' => 'required',
        ]);

        $user = User::findOrFail($id);

        if ($user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun sudah aktif.',
            ]);
        }

        // Verifikasi hCaptcha token ke API hCaptcha
        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => env('HCAPTCHA_SECRET', '0x0000000000000000000000000000000000000000'),
            'response' => $request->input('h-captcha-response'),
        ]);

        $body = $response->json();

        if ($body['success'] ?? false) {
            return response()->json([
                'success' => true,
                'kode_login' => $user->kode_login,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Validasi Captcha gagal.',
        ]);
    }
}
