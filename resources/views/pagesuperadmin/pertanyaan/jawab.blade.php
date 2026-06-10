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
                            <li class="breadcrumb-item" aria-current="page">Jawab Pertanyaan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Jawab Pertanyaan Chatbot</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Formulir Pengisian Jawaban</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pertanyaan-belum-terjawab.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pertanyaan Pengguna</label>
                                        <textarea class="form-control" rows="3" disabled style="background-color: #f8f9fa; font-weight: bold; border-left: 4px solid #ff5252;">{{ $item->pertanyaan }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggapan/Jawaban <span class="text-danger">*</span></label>
                                        <textarea name="jawaban" class="form-control" rows="6" placeholder="Ketikkan jawaban formal dan informatif di sini agar dapat dibaca oleh jemaah..." required></textarea>
                                    </div>
                                    <div class="mb-3 text-muted">
                                        <small><i class="ti ti-info-circle me-1"></i>Menyimpan jawaban ini secara otomatis akan memasukkan pertanyaan dan jawaban tersebut ke dalam daftar <strong>Pertanyaan Umum (FAQ)</strong> berstatus <strong>Published</strong>, serta menghapusnya dari daftar antrean ini.</small>
                                    </div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-between">
                                    <a href="{{ route('pertanyaan.index') }}" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
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
