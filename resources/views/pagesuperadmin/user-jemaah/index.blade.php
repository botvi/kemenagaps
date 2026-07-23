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
                                        <th>Foto Verifikasi</th>
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
                                        <td class="text-center">
                                            @if($item->foto_verifikasi)
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalFotoVerifikasi"
                                                    data-foto="{{ asset('foto_verifikasi/' . $item->foto_verifikasi) }}"
                                                    data-nama="{{ $item->name }}"
                                                    title="Lihat Foto Verifikasi">
                                                    <i class="ti ti-photo me-1"></i> Lihat Foto
                                                </button>
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada</span>
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

<!-- Modal Foto Verifikasi -->
<div class="modal fade" id="modalFotoVerifikasi" tabindex="-1" aria-labelledby="modalFotoVerifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFotoVerifikasiLabel">
                    <i class="ti ti-photo me-2"></i>
                    Foto Verifikasi — <span id="modal-nama-jemaah"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="modal-foto-img"
                    src="#"
                    alt="Foto Verifikasi Jemaah"
                    class="img-fluid rounded shadow"
                    style="max-height: 500px; object-fit: contain;">
            </div>
            <div class="modal-footer">
                <a id="modal-foto-download" href="#" download class="btn btn-success">
                    <i class="ti ti-download me-1"></i> Unduh Foto
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate modal dengan data foto verifikasi jemaah
    const modalFoto = document.getElementById('modalFotoVerifikasi');
    if (modalFoto) {
        modalFoto.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fotoUrl = button.getAttribute('data-foto');
            const namaJemaah = button.getAttribute('data-nama');

            document.getElementById('modal-foto-img').src = fotoUrl;
            document.getElementById('modal-nama-jemaah').textContent = namaJemaah;
            document.getElementById('modal-foto-download').href = fotoUrl;
        });
    }
</script>
@endsection
