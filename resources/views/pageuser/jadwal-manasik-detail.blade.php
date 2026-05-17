@extends('pageuser.layout')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-brand-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <a href="{{ route('user.jadwal-manasik') }}"
                    class="text-brand-100 hover:text-white flex items-center gap-2 mb-4 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Jadwal Manasik
                </a>
                <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $jadwalManasik->judul_kegiatan }}</h1>
                <p class="text-brand-100 text-lg flex items-center gap-2">
                    <span class="bg-brand-500 px-3 py-1 rounded-full text-sm font-semibold">{{ $jadwalManasik->jenis_manasik ?? 'Umum' }}</span>
                    <span>|</span>
                    <span>Pertemuan Ke-{{ $jadwalManasik->pertemuan_ke ?? '-' }}</span>
                </p>
            </div>
            <div class="bg-white/10 p-6 rounded-2xl backdrop-blur-sm border border-white/20 text-center md:text-right">
                <p class="text-brand-100 text-sm mb-1">Status Kegiatan</p>
                @if($jadwalManasik->status == 'Akan Datang')
                    <p class="text-xl font-bold text-blue-200 mb-0">{{ $jadwalManasik->status }}</p>
                @elseif($jadwalManasik->status == 'Sedang Berlangsung')
                    <p class="text-xl font-bold text-yellow-300 mb-0">{{ $jadwalManasik->status }}</p>
                @elseif($jadwalManasik->status == 'Selesai')
                    <p class="text-xl font-bold text-green-300 mb-0">{{ $jadwalManasik->status }}</p>
                @else
                    <p class="text-xl font-bold text-red-300 mb-0">{{ $jadwalManasik->status }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Detail Section -->
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Highlight Info -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-center">
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($jadwalManasik->tanggal)->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Waktu</p>
                                <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($jadwalManasik->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwalManasik->waktu_selesai)->format('H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="font-bold text-gray-900">{{ $jadwalManasik->lokasi }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kuota</p>
                                <p class="font-bold text-gray-900">{{ $jadwalManasik->kuota_peserta ?? 'Tidak Terbatas' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-brand-500"></i> Informasi Kegiatan
                        </h2>
                        <div class="prose max-w-none text-gray-600">
                            @if ($jadwalManasik->deskripsi)
                                {!! nl2br(e($jadwalManasik->deskripsi)) !!}
                            @else
                                <p class="italic">Informasi tambahan belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Pemateri -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3
                            class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                            <i class="fa-solid fa-user-tie text-brand-500"></i> Pemateri
                        </h3>

                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-2xl flex-shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">{{ $jadwalManasik->pemateri }}</h4>
                                <p class="text-sm text-brand-600 font-medium">Pembimbing Manasik</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-sm flex gap-3 items-start">
                            <i class="fa-solid fa-circle-info mt-1"></i>
                            <p>Pastikan untuk datang 15 menit sebelum kegiatan dimulai dan membawa perlengkapan manasik yang diperlukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
