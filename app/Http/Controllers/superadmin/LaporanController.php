<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\CalonJemaah;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonJemaah::with(['user', 'jadwalKeberangkatan.paketHaji']);

        // Filter Status Pendaftaran
        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->status);
        }

        // Filter Jenis Kelamin (lewat relasi user)
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        // Filter Usia (lewat relasi user)
        if ($request->filled('usia_min') || $request->filled('usia_max')) {
            $query->whereHas('user', function ($q) use ($request) {
                if ($request->filled('usia_min')) {
                    $q->where('usia', '>=', $request->usia_min);
                }
                if ($request->filled('usia_max')) {
                    $q->where('usia', '<=', $request->usia_max);
                }
            });
        }

        $jemaahs = $query->latest()->get();

        return view('pagesuperadmin.laporan.index', compact('jemaahs'));
    }

    public function print(Request $request)
    {
        $query = CalonJemaah::with(['user', 'jadwalKeberangkatan.paketHaji']);

        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        if ($request->filled('usia_min') || $request->filled('usia_max')) {
            $query->whereHas('user', function ($q) use ($request) {
                if ($request->filled('usia_min')) {
                    $q->where('usia', '>=', $request->usia_min);
                }
                if ($request->filled('usia_max')) {
                    $q->where('usia', '<=', $request->usia_max);
                }
            });
        }

        $jemaahs  = $query->latest()->get();
        $filters  = $request->only(['status', 'jenis_kelamin', 'usia_min', 'usia_max']);

        return view('pagesuperadmin.laporan.print', compact('jemaahs', 'filters'));
    }
}
