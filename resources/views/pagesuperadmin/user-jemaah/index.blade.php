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
                            <li class="breadcrumb-item" aria-current="page">Data User Jemaah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Daftar Akun Jemaah (User)</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Data User Jemaah</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No WA</th>
                                        <th>Usia</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kode Login</th>
                                        <th>Status Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->no_wa }}</td>
                                        <td>{{ $item->usia ? $item->usia . ' thn' : '-' }}</td>
                                        <td>
                                            @if($item->jenis_kelamin == 'Laki-laki')
                                                <span class="badge bg-info">Laki-laki</span>
                                            @elseif($item->jenis_kelamin == 'Perempuan')
                                                <span class="badge bg-danger">Perempuan</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $item->kode_login }}</strong></td>
                                     
                                        <td>
                                            @if(($item->status ?? 'aktif') == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$item->is_active)
                                            <form action="{{ route('user-jemaah.activate', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mb-1" onclick="return confirm('Aktifkan akun jemaah ini?')">Aktifkan Manual</button>
                                            </form>
                                            @endif
                                            
                                            <form action="{{ route('user-jemaah.generateCode', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info mb-1" onclick="return confirm('Generate kode login baru untuk jemaah ini?')">Generate Kode</button>
                                            </form>

                                            <form action="{{ route('user-jemaah.updateStatus', $item->id) }}" method="POST" class="d-inline ms-1">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()" style="padding-top: 0.2rem; padding-bottom: 0.2rem;">
                                                    <option value="aktif" {{ ($item->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="nonaktif" {{ ($item->status ?? 'aktif') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                </select>
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
