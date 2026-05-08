@extends('pageuser.layout')

@section('content')
    <!-- Detail Artikel -->
    <section class="pt-32 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('user.informasi') }}"
                class="text-brand-600 hover:text-brand-800 flex items-center gap-2 mb-8 transition-colors font-medium">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Artikel
            </a>

            <!-- Article Header -->
            <div class="mb-8">
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                    <span class="flex items-center gap-1 bg-white px-3 py-1 rounded-full shadow-sm">
                        <i class="fa-regular fa-calendar text-brand-500"></i>
                        {{ \Carbon\Carbon::parse($informasi->tanggal_terbit)->translatedFormat('d F Y') }}
                    </span>
                    @if ($informasi->penulis)
                        <span class="flex items-center gap-1 bg-white px-3 py-1 rounded-full shadow-sm">
                            <i class="fa-regular fa-user text-brand-500"></i> Oleh: <span
                                class="font-semibold text-gray-700">{{ $informasi->penulis }}</span>
                        </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    {{ $informasi->judul }}
                </h1>
            </div>

            <!-- Featured Image -->
            <div class="w-full h-80 md:h-[500px] rounded-2xl overflow-hidden mb-12 shadow-md relative group">
                @if ($informasi->thumbnail)
                    <img src="{{ asset('images/informasi/' . $informasi->thumbnail) }}" alt="{{ $informasi->judul }}"
                        class="w-full h-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1594916327341-3b74dbf7f1bc?auto=format&fit=crop&q=80&w=1200&h=600"
                        alt="Placeholder" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-black/5"></div>
            </div>

            <!-- Article Content -->
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
                <div
                    class="prose prose-lg max-w-none text-gray-700 prose-headings:text-gray-900 prose-a:text-brand-600 hover:prose-a:text-brand-800 prose-img:rounded-xl">
                    {!! $informasi->konten !!}
                </div>

                <!-- Share Buttons -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                    <span class="font-bold text-gray-900">Bagikan Artikel:</span>
                    <div class="flex gap-3">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($informasi->judul . ' ' . request()->url()) }}"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($informasi->judul) }}&url={{ urlencode(request()->url()) }}"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if ($recentInfo->count() > 0)
                <div class="mt-20">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8 border-l-4 border-brand-500 pl-4">Artikel Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($recentInfo as $recent)
                            <a href="{{ route('user.informasi.detail', $recent->id) }}"
                                class="group block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all">
                                <div class="h-40 overflow-hidden">
                                    @if ($recent->thumbnail)
                                        <img src="{{ asset('images/informasi/' . $recent->thumbnail) }}" alt="{{ $recent->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1594916327341-3b74dbf7f1bc?auto=format&fit=crop&q=80&w=600&h=400"
                                            alt="Placeholder"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4
                                        class="font-bold text-gray-900 text-sm group-hover:text-brand-600 transition-colors line-clamp-2 mb-2">
                                        {{ $recent->judul }}</h4>
                                    <span
                                        class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recent->tanggal_terbit)->translatedFormat('d M Y') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
