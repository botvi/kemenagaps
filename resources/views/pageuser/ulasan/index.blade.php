@extends('pageuser.layout')

@section('content')
<div class="pt-32 pb-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ulasan & Testimoni</h1>
            <p class="text-gray-600 mt-2">Dengarkan apa yang dikatakan para jemaah kami tentang perjalanan mereka bersama Kemenhaj Kuansing.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Ratings Summary & Form -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Peringkat Keseluruhan</h2>
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-5xl font-extrabold text-brand-600 mb-2">{{ number_format($averageRating, 1) }}</span>
                        
                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 mb-2 text-yellow-400 text-xl">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        
                        <p class="text-gray-500 text-sm">Berdasarkan {{ $totalReviews }} ulasan jemaah</p>
                    </div>
                </div>

                <!-- Write Review Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tulis Ulasan Anda</h3>
                    
                    @auth
                        <form action="{{ route('user.ulasan.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- Rating input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Peringkat Anda</label>
                                <div class="flex items-center gap-2 text-2xl text-gray-300" id="star-rating-container">
                                    <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 5) }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" data-rating="{{ $i }}" class="star-btn hover:scale-115 transition-transform text-yellow-400 focus:outline-none">
                                            <i class="fa-solid fa-star"></i>
                                        </button>
                                    @endfor
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment input -->
                            <div>
                                <label for="ulasan" class="block text-sm font-medium text-gray-700 mb-1">Ulasan Anda</label>
                                <textarea name="ulasan" id="ulasan" rows="4" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all resize-none text-sm" placeholder="Ceritakan pengalaman Anda selama perjalanan Hajj/Umrah..." required>{{ old('ulasan') }}</textarea>
                                @error('ulasan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-lg transition-colors shadow-md shadow-brand-500/20 text-sm">
                                Kirim Ulasan
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6">
                            <i class="fa-solid fa-lock text-gray-400 text-3xl mb-3"></i>
                            <p class="text-sm text-gray-600 mb-4">Anda harus masuk terlebih dahulu untuk memberikan ulasan pelayanan kami.</p>
                            <a href="{{ route('login') }}" class="inline-block w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-lg text-sm transition-colors text-center shadow-md">
                                Masuk Sekarang
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Right Side: List of Reviews -->
            <div class="lg:col-span-2 space-y-6">
                @if($ulasans->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                        <i class="fa-regular fa-comment-dots text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-gray-900 font-bold text-lg mb-2">Belum Ada Ulasan</h3>
                        <p class="text-gray-500 text-sm mb-6">Jadilah yang pertama untuk memberikan ulasan pengalaman berharga Anda.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($ulasans as $ulasan)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all hover:shadow-md">
                                <div>
                                    <div class="flex items-center gap-3 mb-4">
                                        <img src="{{ $ulasan->user->foto_profile ? asset($ulasan->user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($ulasan->user->name).'&background=14b8a6&color=fff' }}" 
                                            alt="{{ $ulasan->user->name }}" 
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $ulasan->user->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $ulasan->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Stars -->
                                    <div class="flex items-center gap-0.5 text-yellow-400 text-sm mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $ulasan->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>

                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 italic">
                                        "{{ $ulasan->ulasan }}"
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $ulasans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@auth
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#star-rating-container .star-btn');
        const ratingInput = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                updateStars(rating);
            });

            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });

            star.addEventListener('mouseout', function() {
                const currentRating = ratingInput.value;
                updateStars(currentRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const starRating = star.getAttribute('data-rating');
                const starIcon = star.querySelector('i');
                if (starRating <= rating) {
                    starIcon.className = 'fa-solid fa-star';
                    star.className = 'star-btn hover:scale-115 transition-transform text-yellow-400 focus:outline-none';
                } else {
                    starIcon.className = 'fa-regular fa-star';
                    star.className = 'star-btn hover:scale-115 transition-transform text-gray-300 focus:outline-none';
                }
            });
        }

        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = star.getAttribute('data-rating');
                const starIcon = star.querySelector('i');
                if (starRating <= rating) {
                    starIcon.className = 'fa-solid fa-star';
                    star.className = 'star-btn hover:scale-115 transition-transform text-yellow-400 focus:outline-none';
                } else {
                    starIcon.className = 'fa-regular fa-star';
                    star.className = 'star-btn hover:scale-115 transition-transform text-gray-300 focus:outline-none';
                }
            });
        }
        
        // Initial setup
        updateStars(ratingInput.value);
    });
</script>
@endauth

@include('sweetalert::alert')
@endsection
