@extends('pageuser.layout')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">

    {{-- ========== WELCOME BANNER ========== --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-600 to-teal-500 text-white">
        {{-- Decorative blobs --}}
        <div class="absolute -top-16 -right-16 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-60 h-60 bg-teal-300/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                {{-- Left: Greeting --}}
                <div class="flex items-center gap-5">
                    <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0f766e&color=fff&size=80' }}"
                        alt="Foto Profil"
                        class="w-20 h-20 rounded-full object-cover border-4 border-white/30 shadow-xl flex-shrink-0">
                    <div>
                        <p class="text-brand-100 text-sm font-medium mb-1">Selamat Datang Kembali 👋</p>
                        <h1 class="text-2xl md:text-3xl font-bold">{{ $user->name }}</h1>
                        <p class="text-brand-100 text-sm mt-1">
                            <i class="fa-solid fa-envelope mr-1"></i>{{ $user->email }}
                        </p>
                    </div>
                </div>

                {{-- Right: Quick Status Cards --}}
                <div class="flex flex-wrap gap-3">
                    {{-- Status Pendaftaran --}}
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-5 py-3 text-center">
                        <p class="text-brand-100 text-xs mb-1">Status Pendaftaran</p>
                        @if($calonJemaah->status_pendaftaran == 'dikonfirmasi')
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-green-300">
                                <i class="fa-solid fa-circle-check"></i> Dikonfirmasi
                            </span>
                        @elseif($calonJemaah->status_pendaftaran == 'pending')
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-yellow-300">
                                <i class="fa-solid fa-clock"></i> Menunggu Konfirmasi
                            </span>
                        @elseif($calonJemaah->status_pendaftaran == 'ditolak')
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-red-300">
                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-gray-300">
                                <i class="fa-solid fa-ban"></i> Dibatalkan
                            </span>
                        @endif
                    </div>

                    {{-- Paket --}}
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-5 py-3 text-center">
                        <p class="text-brand-100 text-xs mb-1">Paket Pilihan</p>
                        <p class="text-sm font-bold text-white">
                            {{ $calonJemaah->jadwalKeberangkatan->paketHaji->nama_paket ?? '-' }}
                        </p>
                    </div>

                    {{-- Keberangkatan --}}
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-5 py-3 text-center">
                        <p class="text-brand-100 text-xs mb-1">Tanggal Keberangkatan</p>
                        <p class="text-sm font-bold text-white">
                            {{ $calonJemaah->jadwalKeberangkatan ? \Carbon\Carbon::parse($calonJemaah->jadwalKeberangkatan->tanggal_keberangkatan)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ===== SIDEBAR KIRI ===== --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Kartu Profil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-8 h-8 bg-brand-50 text-brand-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        Profil Saya
                    </h3>

                    <div class="text-center mb-5">
                        <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=14b8a6&color=fff&size=100' }}"
                            alt="Foto Profil"
                            class="w-24 h-24 rounded-full object-cover border-4 border-brand-50 mx-auto shadow-md">
                        <p class="font-bold text-gray-900 mt-3">{{ $user->name }}</p>
                        <span class="inline-block mt-1 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-100">
                            <i class="fa-solid fa-star text-green-500 mr-1 text-[10px]"></i> Jemaah Terdaftar
                        </span>
                    </div>

                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3 text-gray-600">
                            <i class="fa-solid fa-at w-5 text-center text-brand-500 mt-0.5"></i>
                            <div>
                                <span class="block text-xs text-gray-400">Username</span>
                                <span class="font-medium text-gray-800">{{ $user->username }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600">
                            <i class="fa-solid fa-phone w-5 text-center text-brand-500 mt-0.5"></i>
                            <div>
                                <span class="block text-xs text-gray-400">No. WhatsApp</span>
                                <span class="font-medium text-gray-800">{{ $user->no_wa ?? '-' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600">
                            <i class="fa-solid fa-cake-candles w-5 text-center text-brand-500 mt-0.5"></i>
                            <div>
                                <span class="block text-xs text-gray-400">Usia</span>
                                <span class="font-medium text-gray-800">{{ $user->usia ? $user->usia . ' tahun' : '-' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600">
                            <i class="fa-solid fa-venus-mars w-5 text-center text-brand-500 mt-0.5"></i>
                            <div>
                                <span class="block text-xs text-gray-400">Jenis Kelamin</span>
                                <span class="font-medium text-gray-800">{{ $user->jenis_kelamin ?? '-' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600">
                            <i class="fa-solid fa-key w-5 text-center text-brand-500 mt-0.5"></i>
                            <div>
                                <span class="block text-xs text-gray-400">Kode Login</span>
                                <span class="font-mono font-bold text-gray-800 tracking-widest">{{ $user->kode_login }}</span>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-6 pt-5 border-t border-gray-100 space-y-2">
                        <a href="{{ route('user.profil') }}"
                            class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-brand-50 text-brand-700 rounded-xl hover:bg-brand-100 transition-colors font-medium text-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Profil
                        </a>
                        <a href="{{ route('logout') }}"
                            class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors font-medium text-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                        </a>
                    </div>
                </div>

                {{-- Link Estimasi Haji --}}
                <div class="bg-gradient-to-br from-brand-600 to-teal-500 rounded-2xl p-5 text-white shadow-lg shadow-brand-500/20">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-kaaba text-lg"></i>
                        </div>
                        <h4 class="font-bold text-sm">Cek Estimasi Keberangkatan</h4>
                    </div>
                    <p class="text-brand-100 text-xs mb-4 leading-relaxed">
                        Cek perkiraan tahun keberangkatan Anda menggunakan Nomor Porsi di situs resmi Kemenag.
                    </p>
                    <a href="https://haji.go.id/estimasi-keberangkatan" target="_blank"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-brand-700 text-xs font-bold rounded-full shadow-md hover:bg-brand-50 transition-colors w-full justify-center">
                        Buka Situs Kemenag <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- ===== KONTEN UTAMA ===== --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- ===== DETAIL PENDAFTARAN ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-600 to-teal-500 px-6 py-4 flex items-center gap-3">
                        <i class="fa-solid fa-file-contract text-white text-xl"></i>
                        <h3 class="text-lg font-bold text-white">Detail Pendaftaran Haji / Umrah</h3>
                    </div>

                    <div class="p-6">
                        {{-- Status Alert --}}
                        @if($calonJemaah->status_pendaftaran == 'dikonfirmasi')
                            <div class="mb-5 flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <i class="fa-solid fa-circle-check text-green-600 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-green-800 text-sm">Pendaftaran Dikonfirmasi</p>
                                    <p class="text-green-700 text-xs mt-0.5">Pendaftaran Anda telah dikonfirmasi. Silakan persiapkan dokumen dan ikuti arahan selanjutnya dari pembimbing.</p>
                                </div>
                            </div>
                        @elseif($calonJemaah->status_pendaftaran == 'pending')
                            <div class="mb-5 flex items-start gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <i class="fa-solid fa-clock text-yellow-600 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-yellow-800 text-sm">Menunggu Konfirmasi</p>
                                    <p class="text-yellow-700 text-xs mt-0.5">Pendaftaran Anda sedang dalam proses verifikasi oleh admin. Kami akan segera menghubungi Anda.</p>
                                </div>
                            </div>
                        @elseif($calonJemaah->status_pendaftaran == 'ditolak')
                            <div class="mb-5 flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <i class="fa-solid fa-circle-xmark text-red-600 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-red-800 text-sm">Pendaftaran Ditolak</p>
                                    <p class="text-red-700 text-xs mt-0.5">Mohon maaf, pendaftaran Anda tidak dapat diproses. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                </div>
                            </div>
                        @endif

                        {{-- Info Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Kode Pendaftaran --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1 font-medium">Kode Pendaftaran</p>
                                <p class="font-mono font-bold text-xl text-gray-900 tracking-widest">{{ $calonJemaah->kodelogin }}</p>
                            </div>

                            {{-- Paket --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1 font-medium">Paket Haji/Umrah</p>
                                <p class="font-bold text-gray-900">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->nama_paket ?? '-' }}</p>
                                <span class="text-xs text-brand-600 mt-0.5 block">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->kategori ?? '' }}</span>
                            </div>

                            {{-- Tanggal Keberangkatan --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1 font-medium">Tanggal Keberangkatan</p>
                                <p class="font-bold text-gray-900">
                                    {{ $calonJemaah->jadwalKeberangkatan ? \Carbon\Carbon::parse($calonJemaah->jadwalKeberangkatan->tanggal_keberangkatan)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>

                            {{-- Durasi --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1 font-medium">Durasi Perjalanan</p>
                                <p class="font-bold text-gray-900">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->durasi ?? '-' }}</p>
                            </div>

                            {{-- Maskapai --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1 font-medium">Maskapai</p>
                                <p class="font-bold text-gray-900">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->maskapai ?? '-' }}</p>
                            </div>

                            {{-- Harga Paket --}}
                            <div class="bg-brand-50 rounded-xl p-4 border border-brand-100">
                                <p class="text-xs text-brand-500 mb-1 font-medium">Harga Paket</p>
                                <p class="font-bold text-brand-800 text-lg">
                                    @if($calonJemaah->jadwalKeberangkatan && $calonJemaah->jadwalKeberangkatan->paketHaji)
                                        Rp {{ number_format($calonJemaah->jadwalKeberangkatan->paketHaji->harga, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Fasilitas Paket --}}
                        @if($calonJemaah->jadwalKeberangkatan && $calonJemaah->jadwalKeberangkatan->paketHaji && $calonJemaah->jadwalKeberangkatan->paketHaji->fasilitas)
                        <div class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-xs text-gray-400 mb-2 font-medium">Fasilitas Yang Didapat</p>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->fasilitas }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- ===== JADWAL MANASIK ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </span>
                            <h3 class="text-base font-bold text-gray-900">Jadwal Manasik Mendatang</h3>
                        </div>
                        <a href="{{ route('user.jadwal-manasik') }}" class="text-xs text-brand-600 font-semibold hover:underline flex items-center gap-1">
                            Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="p-6">
                        @forelse($jadwalManasiks as $jadwal)
                        <div class="flex items-start gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            {{-- Tanggal Badge --}}
                            <div class="flex-shrink-0 w-14 text-center bg-brand-50 border border-brand-100 rounded-xl py-2 px-1">
                                <p class="text-brand-700 font-black text-xl leading-none">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</p>
                                <p class="text-brand-500 text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('M') }}</p>
                            </div>

                            <div class="flex-grow min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $jadwal->judul_kegiatan }}</h4>
                                    @if($jadwal->jenis_manasik)
                                    <span class="px-2 py-0.5 bg-teal-50 text-teal-700 text-[10px] font-bold rounded-full border border-teal-100 uppercase">
                                        {{ $jadwal->jenis_manasik }}
                                    </span>
                                    @endif
                                    @if($jadwal->pertemuan_ke)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-medium rounded-full">
                                        Pertemuan {{ $jadwal->pertemuan_ke }}
                                    </span>
                                    @endif
                                </div>
                                <div class="flex items-center flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-gray-400"></i>
                                        {{ $jadwal->lokasi }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-user-tie text-gray-400"></i>
                                        {{ $jadwal->pemateri }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('user.jadwal-manasik.detail', $jadwal->id) }}"
                                class="flex-shrink-0 w-8 h-8 bg-brand-50 hover:bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 text-2xl">
                                <i class="fa-solid fa-calendar-xmark"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada jadwal manasik mendatang.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- ===== ARTIKEL & INFORMASI ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-newspaper"></i>
                            </span>
                            <h3 class="text-base font-bold text-gray-900">Informasi & Artikel Terbaru</h3>
                        </div>
                        <a href="{{ route('user.informasi') }}" class="text-xs text-brand-600 font-semibold hover:underline flex items-center gap-1">
                            Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="p-6">
                        @forelse($informasis as $info)
                        <a href="{{ route('user.informasi.detail', $info->id) }}"
                            class="group flex items-start gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 -mx-2 px-2 rounded-xl transition-colors">

                            {{-- Thumbnail --}}
                            <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-gray-100">
                                @if($info->thumbnail)
                                    <img src="{{ asset('images/informasi/' . $info->thumbnail) }}"
                                        alt="{{ $info->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <img src="https://images.unsplash.com/photo-1594916327341-3b74dbf7f1bc?auto=format&fit=crop&q=80&w=160&h=160"
                                        alt="Placeholder"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                            </div>

                            <div class="flex-grow min-w-0">
                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($info->tanggal_terbit)->translatedFormat('d M Y') }}
                                    @if($info->penulis)
                                        <span>·</span>
                                        <span>{{ $info->penulis }}</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-2 group-hover:text-brand-600 transition-colors">
                                    {{ $info->judul }}
                                </h4>
                                <p class="text-gray-500 text-xs line-clamp-2 mt-1">
                                    {{ Str::limit(strip_tags($info->konten), 100) }}
                                </p>
                            </div>

                            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-brand-500 transition-colors mt-1 flex-shrink-0"></i>
                        </a>
                        @empty
                        <div class="text-center py-10">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 text-2xl">
                                <i class="fa-regular fa-newspaper"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada informasi terbaru.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@include('sweetalert::alert')
@endsection
