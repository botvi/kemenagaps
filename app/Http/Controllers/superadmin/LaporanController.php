<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonJemaah::with(['user', 'paketHaji']);

        // Filter Status Akun (lewat relasi user)
        if ($request->filled('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Filter Jenis Kelamin (lewat relasi user)
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        // Filter Tahun Pendaftaran
        if ($request->filled('tahun_pendaftaran')) {
            $query->where('tahun_pendaftaran', $request->tahun_pendaftaran);
        }

        $jemaahs = $query->latest()->get();

        // Ambil daftar tahun unik dari calon_jemaahs untuk filter
        $list_tahun = CalonJemaah::select('tahun_pendaftaran')
            ->distinct()
            ->orderBy('tahun_pendaftaran', 'desc')
            ->pluck('tahun_pendaftaran');

        return view('pagesuperadmin.laporan.index', compact('jemaahs', 'list_tahun'));
    }

    public function print(Request $request)
    {
        $query = CalonJemaah::with(['user', 'paketHaji']);

        if ($request->filled('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        if ($request->filled('tahun_pendaftaran')) {
            $query->where('tahun_pendaftaran', $request->tahun_pendaftaran);
        }

        $jemaahs  = $query->latest()->get();
        $filters  = $request->only(['status', 'jenis_kelamin', 'tahun_pendaftaran']);

        return view('pagesuperadmin.laporan.print', compact('jemaahs', 'filters'));
    }
}
