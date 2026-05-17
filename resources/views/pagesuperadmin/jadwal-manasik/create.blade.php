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
                            <li class="breadcrumb-item"><a href="{{ route('jadwal-manasik.index') }}">Jadwal Manasik</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Jadwal</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Jadwal Manasik</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('jadwal-manasik.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Kegiatan</label>
                                        <input type="text" name="judul_kegiatan" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" required>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Waktu Mulai</label>
                                            <input type="time" name="waktu_mulai" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Waktu Selesai</label>
                                            <input type="time" name="waktu_selesai" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pemateri</label>
                                        <input type="text" name="pemateri" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Manasik</label>
                                        <select name="jenis_manasik" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="Haji">Haji</option>
                                            <option value="Umroh">Umroh</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pertemuan Ke</label>
                                        <input type="number" name="pertemuan_ke" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kuota Peserta</label>
                                        <input type="number" name="kuota_peserta" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="Akan Datang">Akan Datang</option>
                                            <option value="Sedang Berlangsung">Sedang Berlangsung</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Batal">Batal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
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
