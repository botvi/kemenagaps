<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'username'          => 'required|string|max:50|unique:users,username',
            'no_wa'             => 'required|string|max:20|unique:users,no_wa',
            'usia'              => 'required|integer|min:1|max:120',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'password'          => 'required|min:6|confirmed',
            'agree-terms'       => 'required',
            'foto_verifikasi'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'             => 'Nama lengkap wajib diisi',
            'username.required'         => 'Username wajib diisi',
            'username.unique'           => 'Username sudah digunakan',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi',
            'no_wa.unique'              => 'Nomor WhatsApp sudah terdaftar',
            'usia.required'             => 'Usia wajib diisi',
            'usia.integer'              => 'Usia harus berupa angka',
            'usia.min'                  => 'Usia tidak valid',
            'usia.max'                  => 'Usia tidak valid',
            'jenis_kelamin.required'    => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in'          => 'Jenis kelamin tidak valid',
            'password.required'         => 'Password wajib diisi',
            'password.min'              => 'Password minimal 6 karakter',
            'password.confirmed'        => 'Konfirmasi password tidak cocok',
            'agree-terms.required'      => 'Anda harus menyetujui syarat dan ketentuan',
            'foto_verifikasi.required'  => 'Foto verifikasi wajib diunggah',
            'foto_verifikasi.image'     => 'File harus berupa gambar',
            'foto_verifikasi.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp',
            'foto_verifikasi.max'       => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            // Simpan foto verifikasi ke public/foto_verifikasi
            $fotoVerifikasi = null;
            if ($request->hasFile('foto_verifikasi')) {
                $file = $request->file('foto_verifikasi');
                $fileName = time() . '_' . str_replace(' ', '_', $data['username']) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_verifikasi'), $fileName);
                $fotoVerifikasi = $fileName;
            }

            $user = User::create([
                'name'            => $data['name'],
                'username'        => $data['username'],
                'no_wa'           => $data['no_wa'],
                'usia'            => $data['usia'],
                'jenis_kelamin'   => $data['jenis_kelamin'],
                'password'        => Hash::make($data['password']),
                'role'            => 'user',
                'kode_login'      => strtoupper(\Illuminate\Support\Str::random(6)),
                'is_active'       => false,
                'status'          => 'aktif',
                'foto_verifikasi' => $fotoVerifikasi,
            ]);

            Alert::success('Pendaftaran Berhasil', 'Akun Anda berhasil dibuat. Silakan lakukan aktivasi akun.')->persistent(true);
            return redirect()->route('activation.form', $user->id);

        } catch (\Exception $e) {
            Alert::error('Pendaftaran Gagal', 'Terjadi kesalahan saat melakukan pendaftaran. Silakan coba kembali.');
            return back()->withInput();
        }
    }
}
