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
                            <li class="breadcrumb-item" aria-current="page">Jadwal Keberangkatan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Daftar Jadwal Keberangkatan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Jadwal Keberangkatan</h5>
                        <a href="{{ route('jadwal-keberangkatan.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket Haji</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Kuota</th>
                                        <th>Kuota Terisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwalKeberangkatan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->paketHaji->nama_paket }}</td>
                                        <td>{{ $item->tanggal_keberangkatan }}</td>
                                        <td>{{ $item->kuota }}</td>
                                        <td>{{ $item->kuota_terisi }}</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal-keberangkatan.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('jadwal-keberangkatan.destroy', $item->id) }}" method="POST" class="d-inline">
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
