<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun - Kemenag Kuansing</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('linkskuy') }}/assets/images/logo.ico" type="image/x-icon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6', // Teal 500
                            600: '#0d9488',
                            700: '#0f766e',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-100 m-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Aktivasi Akun</h2>
            <p class="text-sm text-gray-500">Silakan masukkan kode aktivasi (login) yang Anda dapatkan dari Admin untuk melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('activation.submit') }}" class="space-y-5">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Kode Login Field -->
            <div>
                <label for="kode_login" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                    <ion-icon name="key-outline" class="text-lg"></ion-icon>
                    Kode Aktivasi
                </label>
                <input type="text" id="kode_login" name="kode_login"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all uppercase tracking-widest text-center font-bold @error('kode_login') border-red-500 @enderror"
                    placeholder="Masukkan 6 karakter kode" required maxlength="6">
                @error('kode_login')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all flex justify-center items-center mt-2">
                Aktivasi Sekarang
            </button>
            
            <div class="text-center mt-4">
                <a href="{{ route('logout') }}" class="text-sm text-red-500 hover:underline">Keluar</a>
            </div>
        </form>
    </div>

    @include('sweetalert::alert')

    <!-- ionicon link -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons/5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
