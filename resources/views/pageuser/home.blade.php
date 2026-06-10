@extends('pageuser.layout')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-brand-50 -z-20"></div>
        <div
            class="absolute top-0 right-0 -mr-32 -mt-32 w-[600px] h-[600px] rounded-full bg-brand-100 opacity-50 blur-3xl -z-10">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-32 -mb-32 w-[500px] h-[500px] rounded-full bg-teal-100 opacity-50 blur-3xl -z-10">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left z-10">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-brand-100 text-brand-700 font-semibold text-sm mb-6 border border-brand-200">
                        <i class="fa-solid fa-star text-yellow-500 mr-1"></i> Biro Travel Haji & Umrah Terpercaya
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Wujudkan Niat Suci Menuju <span class="text-brand-600">Baitullah</span> Bersama Kami
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0">
                        Kami siap mendampingi perjalanan ibadah Anda dengan fasilitas terbaik, pembimbing bersertifikat, dan
                        pelayanan sepenuh hati.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @if(!Auth::check() || !Auth::user()->calonJemaahs()->exists())
                            <a href="{{ route('user.paket') }}"
                                class="bg-brand-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-brand-700 transition-all shadow-xl shadow-brand-500/30 flex items-center justify-center gap-2">
                                Lihat Paket <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                        <a href="{{ route('user.informasi') }}"
                            class="bg-white text-gray-700 border border-gray-200 px-8 py-3.5 rounded-full font-semibold hover:bg-gray-50 transition-all shadow-sm flex items-center justify-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-8">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">10K+</p>
                            <p class="text-sm text-gray-500 mt-1">Jemaah Berangkat</p>
                        </div>
                        <div class="w-px h-12 bg-gray-200"></div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">15+</p>
                            <p class="text-sm text-gray-500 mt-1">Tahun Pengalaman</p>
                        </div>
                        <div class="w-px h-12 bg-gray-200"></div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 flex items-center">
                                4.9 <i class="fa-solid fa-star text-yellow-400 text-xl ml-1"></i>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Rating Jemaah</p>
                        </div>
                    </div>
                </div>
                <div class="relative hidden lg:block z-10">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-brand-500 to-teal-300 rounded-[2.5rem] transform rotate-3 scale-105 opacity-20 -z-10">
                    </div>
                    <img src="https://st4.depositphotos.com/1998781/29455/v/450/depositphotos_294550834-stock-illustration-panoramic-of-kaaba-for-hajj.jpg"
                        alt="Kaaba"
                        class="w-full h-[600px] object-cover rounded-[2.5rem] shadow-2xl border-4 border-white">

                    <!-- Floating Badge -->
                    <div class="absolute bottom-10 -left-10 bg-white p-4 rounded-2xl shadow-xl border border-gray-100 flex items-center gap-4 animate-bounce"
                        style="animation-duration: 3s;">
                        <div
                            class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Berizin Resmi</p>
                            <p class="text-xs text-gray-500">Kemenag RI</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / Kenapa Memilih Kami -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-gray-600">Dedikasi kami adalah memastikan perjalanan ibadah Anda berjalan lancar, khusyuk,
                    dan menjadi mabrur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-gray-50 rounded-2xl p-8 hover:bg-brand-50 transition-colors border border-transparent hover:border-brand-100 group">
                    <div
                        class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pembimbing Profesional</h3>
                    <p class="text-gray-600">Didampingi oleh Muthawif dan Ustadz berpengalaman yang menguasai tata cara
                        ibadah sesuai sunnah.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="bg-gray-50 rounded-2xl p-8 hover:bg-brand-50 transition-colors border border-transparent hover:border-brand-100 group">
                    <div
                        class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-hotel"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Akomodasi Premium</h3>
                    <p class="text-gray-600">Menginap di hotel bintang 4 & 5 yang dekat dengan Masjidil Haram dan Masjid
                        Nabawi.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="bg-gray-50 rounded-2xl p-8 hover:bg-brand-50 transition-colors border border-transparent hover:border-brand-100 group">
                    <div
                        class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Legalitas Terjamin</h3>
                    <p class="text-gray-600">Terdaftar resmi di Kementrian Agama, amanah, dan telah memberangkatkan ribuan
                        jemaah.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
