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
                            <li class="breadcrumb-item"><a href="{{ route('pertanyaan.index') }}">Pertanyaan Umum</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Pertanyaan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Pertanyaan Umum</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pertanyaan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pertanyaan</label>
                                        <input type="text" name="pertanyaan" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jawaban</label>
                                        <textarea name="jawaban" class="form-control" rows="5" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Urutan</label>
                                        <input type="number" name="urutan" class="form-control" value="0">
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
