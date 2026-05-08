@extends('template-admin.layout')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-superadmin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jadwal-keberangkatan.index') }}">Jadwal Keberangkatan</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Jadwal</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Jadwal Keberangkatan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('jadwal-keberangkatan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Paket Haji</label>
                                        <select name="paket_haji_id" class="form-control" required>
                                            <option value="">Pilih Paket Haji</option>
                                            @foreach($paketHaji as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama_paket }} ({{ $p->kategori }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Keberangkatan</label>
                                        <input type="date" name="tanggal_keberangkatan" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kuota</label>
                                        <input type="number" name="kuota" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                            <label class="form-check-label" for="is_active">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
