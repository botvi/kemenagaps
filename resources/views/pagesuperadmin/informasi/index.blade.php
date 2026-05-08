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
                            <li class="breadcrumb-item" aria-current="page">Informasi</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Daftar Informasi</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Informasi</h5>
                        <a href="{{ route('informasi.create') }}" class="btn btn-primary">Tambah Informasi</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Thumbnail</th>
                                        <th>Judul</th>
                                        <th>Tanggal Terbit</th>
                                        <th>Penulis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($informasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('images/informasi/' . $item->thumbnail) }}" alt="" width="50">
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->tanggal_terbit }}</td>
                                        <td>{{ $item->penulis }}</td>
                                        <td>
                                            @if($item->published)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('informasi.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('informasi.destroy', $item->id) }}" method="POST" class="d-inline">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
