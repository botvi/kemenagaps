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
                            <li class="breadcrumb-item"><a href="{{ route('paket-haji.index') }}">Paket Haji</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Paket Haji</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Paket Haji</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('paket-haji.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Paket</label>
                                        <input type="text" name="nama_paket" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori" class="form-control" required>
                                            <option value="Haji Reguler">Haji Reguler</option>
                                            <option value="Haji Plus">Haji Plus</option>
                                            <option value="Haji Furoda">Haji Furoda</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" name="harga" class="form-control" required>
                                        <small class="text-muted d-block mt-1">*Harga sewaktu-waktu akan berubah sesuai kebijakan pemerintah</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Biaya DP</label>
                                        <input type="number" name="biaya_dp" class="form-control" value="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Durasi (contoh: 12 Hari)</label>
                                        <input type="text" name="durasi" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Maskapai</label>
                                        <input type="text" name="maskapai" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Fasilitas</label>
                                        <textarea name="fasilitas" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="published" id="published" checked>
                                            <label class="form-check-label" for="published">Published</label>
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
