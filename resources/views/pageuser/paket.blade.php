@extends('pageuser.layout')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-brand-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Pilihan Paket Ibadah</h1>
            <p class="text-brand-100 max-w-2xl mx-auto text-lg">Berbagai pilihan paket Haji dan Umrah yang dirancang sesuai dengan kebutuhan dan kenyamanan Anda.</p>
        </div>
    </section>

    <!-- Paket Section -->
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($paketHajis as $paket)
                <!-- Package Card -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow border border-gray-100 overflow-hidden group flex flex-col h-full">
                    <div class="h-48 bg-brand-50 flex items-center justify-center relative overflow-hidden group-hover:bg-brand-100 transition-colors">
                        <i class="fa-solid fa-kaaba text-7xl text-brand-500 opacity-80 group-hover:scale-110 transition-transform duration-500"></i>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-brand-700 shadow-sm">
                            {{ $paket->kategori }}
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-brand-600 transition-colors">{{ $paket->nama_paket }}</h3>
                        </div>
                        <div class="text-brand-600 font-bold text-2xl mb-1">
                            Rp {{ number_format($paket->harga, 0, ',', '.') }}
                        </div>
                        <div class="text-[10px] text-gray-500 italic mb-4">
                            *Harga sewaktu-waktu akan berubah sesuai kebijakan pemerintah
                        </div>
                        
                        <div class="space-y-3 mb-6 text-sm text-gray-600 flex-grow">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-clock text-gray-400 w-5 text-center"></i>
                                <span>Durasi: <strong>{{ $paket->durasi }}</strong></span>
                            </div>
                            @if($paket->maskapai)
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-plane-departure text-gray-400 w-5 text-center"></i>
                                <span>Maskapai: <strong>{{ $paket->maskapai }}</strong></span>
                            </div>
                            @endif

                        </div>
                        
                        <a href="{{ route('user.paket.detail', $paket->id) }}" class="block w-full py-3 px-4 bg-brand-50 text-brand-700 text-center rounded-xl font-semibold hover:bg-brand-600 hover:text-white transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum Ada Paket</h3>
                    <p class="text-gray-500">Paket perjalanan saat ini belum tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
