@extends('template-admin.layout')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-superadmin') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Laporan Jemaah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Laporan Data Jemaah Haji</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="ti ti-filter me-2 text-primary"></i>Filter Laporan</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.index') }}" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Status Akun -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Status Akun</label>
                                    <select name="status" class="form-select">
                                        <option value="">-- Semua Status --</option>
                                        <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="">-- Semua --</option>
                                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <!-- Usia Min -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Usia Min</label>
                                    <input type="number" name="usia_min" class="form-control" min="1" max="120"
                                        placeholder="Contoh: 20" value="{{ request('usia_min') }}">
                                </div>

                                <!-- Usia Max -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Usia Max</label>
                                    <input type="number" name="usia_max" class="form-control" min="1" max="120"
                                        placeholder="Contoh: 60" value="{{ request('usia_max') }}">
                                </div>

                                <!-- Tombol -->
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search me-1"></i>Cari
                                    </button>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="ti ti-refresh me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Hasil -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Hasil Data Jemaah</h5>
                            <small class="text-muted">Menampilkan {{ $jemaahs->count() }} data</small>
                        </div>
                        <!-- Tombol Print -->
                        <a href="{{ route('laporan.print', request()->query()) }}" target="_blank"
                            class="btn btn-success">
                            <i class="ti ti-printer me-1"></i>Cetak / Print
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width:40px;">No</th>
                                        <th>Nama Jemaah</th>
                                        <th>Username</th>
                                        <th>No. WA</th>
                                        <th>Usia</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Paket Haji</th>
                                        <th>Status Akun</th>
                                        <th>Tgl Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jemaahs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>{{ $item->user->username ?? '-' }}</td>
                                        <td>{{ $item->user->no_wa ?? '-' }}</td>
                                        <td>{{ $item->user->usia ? $item->user->usia . ' thn' : '-' }}</td>
                                        <td>
                                            @if($item->user->jenis_kelamin == 'Laki-laki')
                                                <span class="badge bg-info">Laki-laki</span>
                                            @elseif($item->user->jenis_kelamin == 'Perempuan')
                                                <span class="badge bg-danger">Perempuan</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        <td>{{ $item->paketHaji->nama_paket ?? '-' }}</td>
                                        <td>
                                            @if(($item->user->status ?? 'aktif') == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5 text-muted">
                                            <i class="ti ti-inbox fs-2 d-block mb-2"></i>
                                            Tidak ada data yang sesuai dengan filter.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /pc-content -->
</div><!-- /pc-container -->
@endsection
