@extends('pageuser.layout')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-brand-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <a href="{{ route('user.paket') }}" class="text-brand-100 hover:text-white flex items-center gap-2 mb-4 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Paket
                </a>
                <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $paket->nama_paket }}</h1>
                <p class="text-brand-100 text-lg flex items-center gap-2">
                    <span class="bg-brand-500 px-3 py-1 rounded-full text-sm font-semibold">{{ $paket->kategori }}</span>
                    <span>|</span>
                    <span>Durasi {{ $paket->durasi }}</span>
                </p>
            </div>
            <div class="bg-white/10 p-6 rounded-2xl backdrop-blur-sm border border-white/20 text-center md:text-right">
                <p class="text-brand-100 text-sm mb-1">Harga Mulai Dari</p>
                <p class="text-3xl font-bold text-white mb-4">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                <a href="{{ route('login') }}" class="bg-white text-brand-700 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition-colors shadow-lg shadow-black/10 inline-block w-full">
                    Daftar Sekarang
                </a>
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-wrap gap-6 justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Durasi</p>
                                <p class="font-bold text-gray-900">{{ $paket->durasi }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Maskapai</p>
                                <p class="font-bold text-gray-900">{{ $paket->maskapai ?? 'Belum Ditentukan' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Biaya DP</p>
                                <p class="font-bold text-gray-900">Rp {{ number_format($paket->biaya_dp, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-star text-brand-500"></i> Fasilitas Paket
                        </h2>
                        <div class="prose max-w-none text-gray-600">
                            @if($paket->fasilitas)
                                {!! nl2br(e($paket->fasilitas)) !!}
                            @else
                                <p class="italic">Informasi fasilitas belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Jadwal Keberangkatan -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                            <i class="fa-regular fa-calendar-days text-brand-500"></i> Jadwal Keberangkatan
                        </h3>
                        
                        <div class="space-y-4">
                            @forelse ($paket->jadwalKeberangkatan as $jadwal)
                            <div class="p-4 rounded-xl border {{ $jadwal->is_active ? 'border-brand-200 bg-brand-50' : 'border-gray-200 bg-gray-50' }}">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_keberangkatan)->translatedFormat('d F Y') }}
                                    </span>
                                    @if($jadwal->is_active)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">Tersedia</span>
                                    @else
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-bold">Penuh</span>
                                    @endif
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    @php
                                        $percentage = $jadwal->kuota > 0 ? ($jadwal->kuota_terisi / $jadwal->kuota) * 100 : 0;
                                    @endphp
                                    <div class="bg-brand-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Terisi: {{ $jadwal->kuota_terisi }}</span>
                                    <span>Kuota: {{ $jadwal->kuota }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-sm text-center py-4">Belum ada jadwal keberangkatan untuk paket ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
