<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header justify-content-center">
            <a href="/dashboard-superadmin" class="b-brand text-primary">
                <span class="b-title">Kemenhaj Kuansing</span>
            </a>
        </div>
        @if (Auth::user()->role == 'superadmin')
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="/dashboard-superadmin" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Data Kemenhaj Kuansing</label>
                        <i class="ti ti-dashboard"></i>
                    </li>


                    <li class="pc-item">
                        <a href="{{ route('informasi.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-news"></i></span>
                            <span class="pc-mtext">Informasi</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('paket-haji.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-package"></i></span>
                            <span class="pc-mtext">Paket Haji</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('jadwal-keberangkatan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                            <span class="pc-mtext">Jadwal Keberangkatan</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('jadwal-manasik.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-book"></i></span>
                            <span class="pc-mtext">Jadwal Manasik</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('pertanyaan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-help"></i></span>
                            <span class="pc-mtext">Pertanyaan Umum</span>
                            @php
                                $unansweredCount = \App\Models\PertanyaanBelumTerjawab::count();
                            @endphp
                            @if($unansweredCount > 0)
                                <span class="badge bg-danger ms-2">{{ $unansweredCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('calon-jemaah.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Calon Jemaah</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('user-jemaah.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-user"></i></span>
                            <span class="pc-mtext">Data User/Jemaah</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('ulasan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-star"></i></span>
                            <span class="pc-mtext">Ulasan Jemaah</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('laporan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                            <span class="pc-mtext">Laporan Jemaah</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
