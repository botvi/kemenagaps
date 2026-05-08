@extends('pageuser.layout')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-brand-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita & Informasi Terkini</h1>
            <p class="text-brand-100 max-w-2xl mx-auto text-lg">Dapatkan informasi terbaru seputar ibadah Haji & Umrah serta inspirasi Islami untuk menemani perjalanan spiritual Anda.</p>
        </div>
    </section>

    <!-- Informasi / Blog Section -->
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($informasis as $info)
                <a href="{{ route('user.informasi.detail', $info->id) }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all">
                    <div class="relative overflow-hidden h-60 bg-gray-100">
                        @if($info->thumbnail)
                            <img src="{{ asset('images/informasi/' . $info->thumbnail) }}" alt="{{ $info->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://images.unsplash.com/photo-1594916327341-3b74dbf7f1bc?auto=format&fit=crop&q=80&w=600&h=400" alt="Placeholder" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                            <span class="flex items-center gap-1"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($info->tanggal_terbit)->translatedFormat('d M Y') }}</span>
                            @if($info->penulis)
                            <span class="flex items-center gap-1"><i class="fa-regular fa-user"></i> {{ $info->penulis }}</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brand-600 transition-colors line-clamp-2">
                            {{ $info->judul }}
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($info->konten), 120) }}
                        </p>
                        <span class="text-brand-600 font-semibold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long"></i>
                        </span>
                    </div>
                </a>
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-2xl">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada Artikel</h3>
                    <p class="text-gray-500">Informasi dan berita belum ditambahkan saat ini.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($informasis->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $informasis->links() }}
            </div>
            @endif
        </div>
    </section>
@endsection
