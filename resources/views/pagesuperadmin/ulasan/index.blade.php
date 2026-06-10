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
                            <li class="breadcrumb-item" aria-current="page">Ulasan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Kelola Ulasan Jemaah</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Ulasan Jemaah</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jemaah</th>
                                        <th>Rating</th>
                                        <th>Pesan Ulasan</th>
                                        <th>Status</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ulasans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($ulasans->currentPage() - 1) * $ulasans->perPage() }}</td>
                                        <td>{{ $item->user->name ?? 'Guest User' }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $item->rating)
                                                    <i class="fas fa-star text-warning" style="font-size: 16px;"></i>
                                                @else
                                                    <i class="far fa-star text-muted" style="font-size: 16px;"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-1 font-weight-bold">({{ $item->rating }}/5)</span>
                                        </td>
                                        <td>{{ Str::limit($item->ulasan, 60) }}</td>
                                        <td>
                                            @if($item->published)
                                                <span class="badge bg-success">Dipublikasikan</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Disembunyikan</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('ulasan.update', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                @if($item->published)
                                                    <input type="hidden" name="published" value="0">
                                                    <button type="submit" class="btn btn-sm btn-warning">Sembunyikan</button>
                                                @else
                                                    <input type="hidden" name="published" value="1">
                                                    <button type="submit" class="btn btn-sm btn-success">Tampilkan</button>
                                                @endif
                                            </form>
                                            
                                            <form action="{{ route('ulasan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Belum ada ulasan jemaah.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $ulasans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
