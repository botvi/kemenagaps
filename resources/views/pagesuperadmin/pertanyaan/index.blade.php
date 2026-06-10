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
                            <li class="breadcrumb-item" aria-current="page">Pertanyaan Umum</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Kelola Pertanyaan & Chatbot</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manajemen Pertanyaan Umum</h5>
                    </div>
                    <div class="card-body">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="pertanyaanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane" aria-selected="true">
                                    <i class="ti ti-help me-2"></i>Pertanyaan Umum (FAQ)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="unanswered-tab" data-bs-toggle="tab" data-bs-target="#unanswered-tab-pane" type="button" role="tab" aria-controls="unanswered-tab-pane" aria-selected="false">
                                    <i class="ti ti-message-dots me-2"></i>Belum Terjawab
                                    @if($pertanyaanBelumTerjawab->count() > 0)
                                        <span class="badge bg-danger ms-2">{{ $pertanyaanBelumTerjawab->count() }}</span>
                                    @endif
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="pertanyaanTabContent">
                            <!-- FAQ TAB -->
                            <div class="tab-pane fade show active" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab" tabindex="0">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-muted">Daftar Tanya Jawab yang Aktif di Chatbot</h6>
                                    <a href="{{ route('pertanyaan.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus me-1"></i>Tambah Pertanyaan</a>
                                </div>
                                <div class="table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pertanyaan</th>
                                                <th>Jawaban</th>
                                                <th>Urutan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaanUmum as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->pertanyaan }}</td>
                                                <td>{{ Str::limit($item->jawaban, 50) }}</td>
                                                <td>{{ $item->urutan }}</td>
                                                <td>
                                                    @if($item->published)
                                                        <span class="badge bg-success">Published</span>
                                                    @else
                                                        <span class="badge bg-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('pertanyaan.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                    <form action="{{ route('pertanyaan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- UNANSWERED TAB -->
                            <div class="tab-pane fade" id="unanswered-tab-pane" role="tabpanel" aria-labelledby="unanswered-tab" tabindex="0">
                                <div class="mb-3">
                                    <h6 class="mb-0 text-muted">Daftar Pertanyaan Jemaah yang Belum Diketahui oleh Chatbot</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Pertanyaan</th>
                                                <th style="width: 15%">Jumlah Ditanyakan</th>
                                                <th style="width: 20%">Tanggal Pertama Masuk</th>
                                                <th style="width: 15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaanBelumTerjawab as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $item->pertanyaan }}</strong></td>
                                                <td>
                                                    <span class="badge bg-light-danger text-danger font-weight-bold" style="font-size: 0.9rem;">
                                                        {{ $item->jumlah_ditanyakan }}x
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                                                <td>
                                                    <a href="{{ route('pertanyaan-belum-terjawab.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-edit me-1"></i>Jawab
                                                    </a>
                                                    <form action="{{ route('pertanyaan-belum-terjawab.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin mengabaikan/menghapus pertanyaan ini?')">
                                                            <i class="ti ti-trash me-1"></i>Abaikan
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if($pertanyaanBelumTerjawab->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    Tidak ada pertanyaan belum terjawab saat ini. Semua pertanyaan chatbot telah terakomodasi! 😊
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
