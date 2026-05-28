@extends('pageuser.layout')

@section('content')
<div class="pt-32 pb-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-600 mt-2">Kelola informasi profil dan lihat status pendaftaran Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Profile -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=14b8a6&color=fff' }}" 
                                alt="Profile" 
                                class="w-32 h-32 rounded-full object-cover border-4 border-brand-50 mx-auto">
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mt-4">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-3 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Jemaah Terdaftar</span>
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-gray-600">
                                <i class="fa-solid fa-phone w-5 text-center text-brand-500"></i>
                                <span>{{ $user->no_wa }}</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-600">
                                <i class="fa-solid fa-key w-5 text-center text-brand-500"></i>
                                <span>Kode Login: <strong class="text-gray-900">{{ $user->kode_login }}</strong></span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-600">
                                <i class="fa-solid fa-cake-candles w-5 text-center text-brand-500"></i>
                                <span>Usia: <strong class="text-gray-900">{{ $user->usia ?? '-' }} tahun</strong></span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-600">
                                <i class="fa-solid fa-venus-mars w-5 text-center text-brand-500"></i>
                                <span>{{ $user->jenis_kelamin ?? '-' }}</span>
                            </li>
                        </ul>
                        
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors font-medium">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Info Pendaftaran -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-brand-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fa-solid fa-kaaba"></i> Status Pendaftaran Haji/Umrah
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($calonJemaah)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Paket Pilihan</p>
                                    <p class="font-bold text-gray-900">{{ $calonJemaah->jadwalKeberangkatan->paketHaji->nama_paket ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Status Pendaftaran</p>
                                    @if($calonJemaah->status_pendaftaran == 'pending')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-medium">
                                            <i class="fa-solid fa-clock text-xs"></i> Menunggu Konfirmasi
                                        </span>
                                    @elseif($calonJemaah->status_pendaftaran == 'dikonfirmasi')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                            <i class="fa-solid fa-check-circle text-xs"></i> Dikonfirmasi
                                        </span>
                                    @elseif($calonJemaah->status_pendaftaran == 'ditolak')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                                            <i class="fa-solid fa-times-circle text-xs"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                                            <i class="fa-solid fa-ban text-xs"></i> Dibatalkan
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Jadwal Keberangkatan</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $calonJemaah->jadwalKeberangkatan ? \Carbon\Carbon::parse($calonJemaah->jadwalKeberangkatan->tanggal_keberangkatan)->translatedFormat('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Kode Pendaftaran</p>
                                    <p class="font-mono font-bold text-gray-900">{{ $calonJemaah->kodelogin }}</p>
                                </div>
                            </div>
                            
                            @if($calonJemaah->status_pendaftaran == 'dikonfirmasi')
                                <div class="mt-6 p-4 bg-green-50 border border-green-100 rounded-xl">
                                    <p class="text-sm text-green-800">
                                        <i class="fa-solid fa-info-circle mr-1"></i> Pendaftaran Anda telah dikonfirmasi. Silakan persiapkan dokumen dan ikuti arahan selanjutnya dari pembimbing.
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                    <i class="fa-solid fa-file-excel"></i>
                                </div>
                                <h4 class="text-gray-900 font-medium mb-2">Belum Ada Pendaftaran</h4>
                                <p class="text-gray-500 text-sm mb-6">Anda belum terdaftar pada paket haji atau umrah manapun.</p>
                                <a href="{{ route('user.paket') }}" class="inline-block px-6 py-2 bg-brand-600 text-white rounded-full text-sm font-medium hover:bg-brand-700 transition-colors">
                                    Lihat Paket Kami
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Update Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Pengaturan Profil</h3>
                    
                    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Usia</label>
                                <input type="number" name="usia" min="1" max="120" value="{{ old('usia', $user->usia) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all" placeholder="Contoh: 35">
                                @error('usia') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all bg-white">
                                    <option value="" disabled {{ !$user->jenis_kelamin ? 'selected' : '' }}>-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-xs text-gray-400 font-normal">(Tidak bisa diubah)</span></label>
                            <input type="text" value="{{ $user->username }}" readonly class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 outline-none cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs text-gray-400 font-normal">(Tidak bisa diubah)</span></label>
                            <input type="email" value="{{ $user->email }}" readonly class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 outline-none cursor-not-allowed">
                        </div>

                        <div class="border-t border-gray-100 pt-5 mt-2">
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Ubah Password <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <input type="password" name="password" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-5 mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil Baru</label>
                            <input type="file" name="foto_profile" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-brand-50 file:text-brand-700
                                hover:file:bg-brand-100
                                transition-all">
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 transition-colors shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('sweetalert::alert')
@endsection
