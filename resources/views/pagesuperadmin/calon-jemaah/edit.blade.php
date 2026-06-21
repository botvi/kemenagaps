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
                            <li class="breadcrumb-item" aria-current="page">Edit Calon Jemaah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit Calon Jemaah</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('calon-jemaah.update', $calonJemaah->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User</label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="">Pilih User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $calonJemaah->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->username }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Paket Haji</label>
                                        <select name="paket_haji_id" class="form-control" required>
                                            <option value="">Pilih Paket Haji</option>
                                            @foreach($paketHaji as $p)
                                                @if($p->kategori == 'Haji Reguler')
                                                    <option value="{{ $p->id }}" {{ $calonJemaah->paket_haji_id == $p->id ? 'selected' : '' }}>{{ $p->nama_paket }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="mb-3">
                                        <label for="tahun_pendaftaran" class="form-label">Tahun Pendaftaran</label>
                                        <input type="number" name="tahun_pendaftaran" id="tahun_pendaftaran"
                                            class="form-control" value="{{ $calonJemaah->tahun_pendaftaran }}" required min="1900"
                                            max="2100">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kode Login</label>
                                        <input type="text" name="kodelogin" class="form-control" value="{{ $calonJemaah->kodelogin }}" required>
                                    </div>
                                  
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
