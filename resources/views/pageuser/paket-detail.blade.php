@extends('pageuser.layout')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-brand-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <a href="{{ route('user.paket') }}"
                    class="text-brand-100 hover:text-white flex items-center gap-2 mb-4 transition-colors">
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
                <p class="text-3xl font-bold text-white mb-1">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                <p class="text-[10px] text-brand-100 opacity-80 italic mb-4">*Harga sewaktu-waktu akan berubah sesuai kebijakan pemerintah</p>
                {{-- <a href="{{ route('login') }}" class="bg-white text-brand-700 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition-colors shadow-lg shadow-black/10 inline-block w-full">
                    Daftar Sekarang
                </a> --}}
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
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-wrap gap-6 justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Durasi</p>
                                <p class="font-bold text-gray-900">{{ $paket->durasi }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Maskapai</p>
                                <p class="font-bold text-gray-900">{{ $paket->maskapai ?? 'Belum Ditentukan' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-xl">
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
                            @if ($paket->fasilitas)
                                {!! nl2br(e($paket->fasilitas)) !!}
                            @else
                                <p class="italic">Informasi fasilitas belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Info Pendaftaran -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3
                            class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                            <i class="fa-solid fa-file-signature text-brand-500"></i> Pendaftaran Paket
                        </h3>

                     
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
