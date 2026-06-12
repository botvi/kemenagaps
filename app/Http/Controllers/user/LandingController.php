<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketHaji;
use App\Models\Informasi;
use App\Models\PertanyaanUmum;
use App\Models\JadwalManasik;

class LandingController extends Controller
{
    public function index()
    {
        $paketHajis = PaketHaji::where('published', true)->take(3)->get();
        $informasis = Informasi::where('published', true)->latest()->take(3)->get();
        
        return view('pageuser.home', compact('paketHajis', 'informasis'));
    }

    public function paket()
    {
        $paketHajis = PaketHaji::where('published', true)->get();
        return view('pageuser.paket', compact('paketHajis'));
    }

    public function paketDetail($id)
    {
        $paket = PaketHaji::where('published', true)->findOrFail($id);
        return view('pageuser.paket-detail', compact('paket'));
    }

    public function informasi()
    {
        $informasis = Informasi::where('published', true)->latest()->paginate(9);
        return view('pageuser.informasi', compact('informasis'));
    }

    public function informasiDetail($id)
    {
        $informasi = Informasi::where('published', true)->findOrFail($id);
        $recentInfo = Informasi::where('published', true)->where('id', '!=', $id)->latest()->take(3)->get();
        return view('pageuser.informasi-detail', compact('informasi', 'recentInfo'));
    }

    public function faq()
    {
        $faqs = PertanyaanUmum::where('published', true)->orderBy('urutan', 'asc')->get();
        return view('pageuser.faq', compact('faqs'));
    }

    public function jadwalManasik()
    {
        $jadwalManasiks = JadwalManasik::latest()->paginate(9);
        return view('pageuser.jadwal-manasik', compact('jadwalManasiks'));
    }

    public function jadwalManasikDetail($id)
    {
        $jadwalManasik = JadwalManasik::findOrFail($id);
        return view('pageuser.jadwal-manasik-detail', compact('jadwalManasik'));
    }
}
