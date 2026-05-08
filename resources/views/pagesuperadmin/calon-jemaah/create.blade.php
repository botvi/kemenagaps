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
                            <li class="breadcrumb-item"><a href="{{ route('calon-jemaah.index') }}">Calon Jemaah</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Calon Jemaah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Calon Jemaah</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('calon-jemaah.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User</label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="">Pilih User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jadwal Keberangkatan</label>
                                        <select name="jadwal_keberangkatan_id" class="form-control" required>
                                            <option value="">Pilih Jadwal</option>
                                            @foreach($jadwalKeberangkatan as $j)
                                                <option value="{{ $j->id }}">{{ $j->paketHaji->nama_paket }} - {{ $j->tanggal_keberangkatan }} (Sisa Kuota: {{ $j->kuota - $j->kuota_terisi }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kode Login</label>
                                        <input type="text" name="kodelogin" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status Pendaftaran</label>
                                        <select name="status_pendaftaran" class="form-control" required>
                                            <option value="pending">Pending</option>
                                            <option value="dikonfirmasi">Dikonfirmasi</option>
                                            <option value="ditolak">Ditolak</option>
                                            <option value="cancel">Cancel</option>
                                        </select>
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
