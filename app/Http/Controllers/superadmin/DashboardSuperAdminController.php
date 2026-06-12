<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CalonJemaah;
use Illuminate\Support\Facades\DB;

class DashboardSuperAdminController extends Controller
{
   public function index()
   {
      $currentYear = now()->year;
      $users = User::where('role', 'user');

      // --- Stat Total ---
      $pelanggan = $users->count();

      // --- Chart 1: Distribusi Usia (kelompok umur) ---
      $usiaGroups = [
         '< 20 thn'  => [1,  19],
         '20 - 29'   => [20, 29],
         '30 - 39'   => [30, 39],
         '40 - 49'   => [40, 49],
         '50 - 59'   => [50, 59],
         '60+'       => [60, 120],
      ];

      $usiaLabels = [];
      $usiaData   = [];
      foreach ($usiaGroups as $label => [$min, $max]) {
         $usiaLabels[] = $label;
         $usiaData[]   = User::where('role', 'user')
            ->whereBetween('usia', [$min, $max])
            ->count();
      }

      // --- Chart 2: Jenis Kelamin ---
      $lakiLaki  = User::where('role', 'user')->where('jenis_kelamin', 'Laki-laki')->count();
      $perempuan = User::where('role', 'user')->where('jenis_kelamin', 'Perempuan')->count();
      $belumIsi  = User::where('role', 'user')->whereNull('jenis_kelamin')->count();

      // --- Chart 3: Pendaftar Calon Jemaah per Tahun (3 tahun terakhir s/d tahun ini) ---
      $years = [$currentYear - 3, $currentYear - 2, $currentYear - 1, $currentYear];
      $yearLabels = array_map('strval', $years);
      $yearData   = [];
      foreach ($years as $year) {
         $yearData[] = CalonJemaah::where('tahun_pendaftaran', $year)->count();
      }

      return view('pagesuperadmin.dashboard.index', compact(
         'pelanggan',
         'usiaLabels', 'usiaData',
         'lakiLaki', 'perempuan', 'belumIsi',
         'yearLabels', 'yearData'
      ));
   }
}
