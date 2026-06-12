<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use App\Models\Informasi;
use App\Models\JadwalManasik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JemaahDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data calon jemaah beserta relasi paket dan jadwal keberangkatan
        $calonJemaah = CalonJemaah::with(['paketHaji'])
            ->where('user_id', $user->id)
            ->first();

        // Jika ternyata bukan calon jemaah, arahkan ke home
        if (!$calonJemaah) {
            return redirect()->route('home');
        }

        // Ambil jadwal manasik mendatang (berdasarkan tanggal >= hari ini)
        $jadwalManasiks = JadwalManasik::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->take(4)
            ->get();

        // Ambil informasi/artikel terbaru
        $informasis = Informasi::where('published', true)
            ->latest()
            ->take(3)
            ->get();

        return view('pageuser.jemaah-dashboard', compact('user', 'calonJemaah', 'jadwalManasiks', 'informasis'));
    }
}
