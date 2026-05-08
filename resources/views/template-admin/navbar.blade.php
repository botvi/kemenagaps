<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header justify-content-center">
            <a href="/dashboard-superadmin" class="b-brand text-primary">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSA3ejR6sDhtz1fhMAM3-GDxUQO4Y6EYcsxOg&s"
                    alt="Logo" style="height: 60px;">
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
                        <label>Data Kemenag Kuansing</label>
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
                        <a href="{{ route('pertanyaan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-help"></i></span>
                            <span class="pc-mtext">Pertanyaan Umum</span>
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
                </ul>
            </div>
        @endif
    </div>
</nav>
