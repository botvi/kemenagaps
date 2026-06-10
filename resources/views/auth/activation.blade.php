<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun - Kemenhaj Kuansing</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('linkskuy') }}/assets/images/logo.ico" type="image/x-icon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- hCaptcha JS -->
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

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

        <form method="POST" action="{{ route('activation.submit', $user->id) }}" class="space-y-5">
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

            <!-- hCaptcha Widget & Reveal Area -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Verifikasi Manusia (Buka Kode Aktivasi)</label>
                
                <div class="flex justify-center">
                    <div class="h-captcha" 
                         data-sitekey="{{ env('HCAPTCHA_SITEKEY', '10000000-ffff-ffff-ffff-ffffffffffff') }}" 
                         data-callback="onCaptchaSuccess">
                    </div>
                </div>

                <!-- Loading State -->
                <div id="captcha-loading" class="hidden flex flex-col items-center justify-center py-2">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-brand-600"></div>
                    <span class="text-xs text-gray-500 mt-2">Memverifikasi captcha...</span>
                </div>

                <!-- Reveal Box (Hidden by default, shown when verified) -->
                <div id="revealed-code-box" class="hidden transition-all duration-500 ease-out transform scale-95 opacity-0">
                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-3 text-center">
                        <span class="text-xs text-teal-600 block mb-1 font-medium">Kode Anda (Telah Diisi Otomatis):</span>
                        <div class="flex items-center justify-center gap-2">
                            <span id="revealed-code" class="text-2xl font-bold tracking-widest text-teal-700 uppercase"></span>
                            <button type="button" id="btn-copy-code" class="p-1.5 bg-teal-100 hover:bg-teal-200 text-teal-700 rounded-md transition-colors flex items-center justify-center" title="Salin Kode">
                                <ion-icon name="copy-outline" class="text-lg"></ion-icon>
                            </button>
                        </div>
                        <span id="copy-status" class="text-xs text-teal-500 block mt-1 hidden">Berhasil disalin!</span>
                    </div>
                </div>
            </div>

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

    <!-- hCaptcha JS Callback Script -->
    <script>
        function onCaptchaSuccess(token) {
            const loadingIndicator = document.getElementById('captcha-loading');
            const codeBox = document.getElementById('revealed-code-box');
            const revealedCode = document.getElementById('revealed-code');
            const codeInput = document.getElementById('kode_login');

            // Show loading, hide code box
            loadingIndicator.classList.remove('hidden');
            codeBox.classList.add('hidden');

            fetch("{{ route('activation.reveal', $user->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    "h-captcha-response": token
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingIndicator.classList.add('hidden');
                if (data.success) {
                    // Autofill the input field
                    codeInput.value = data.kode_login;
                    
                    // Show revealed code
                    revealedCode.textContent = data.kode_login;
                    codeBox.classList.remove('hidden');
                    
                    // Trigger animation
                    setTimeout(() => {
                        codeBox.classList.remove('scale-95', 'opacity-0');
                        codeBox.classList.add('scale-100', 'opacity-100');
                    }, 50);
                } else {
                    alert('Gagal memverifikasi captcha: ' + (data.message || 'Silakan coba lagi.'));
                    if (typeof hcaptcha !== 'undefined') {
                        hcaptcha.reset();
                    }
                }
            })
            .catch(error => {
                loadingIndicator.classList.add('hidden');
                console.error("Error:", error);
                alert("Terjadi kesalahan sistem. Silakan coba kembali.");
                if (typeof hcaptcha !== 'undefined') {
                    hcaptcha.reset();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btnCopy = document.getElementById('btn-copy-code');
            if (btnCopy) {
                btnCopy.addEventListener('click', function() {
                    const code = document.getElementById('revealed-code').textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        const status = document.getElementById('copy-status');
                        status.classList.remove('hidden');
                        setTimeout(() => {
                            status.classList.add('hidden');
                        }, 2000);
                    }).catch(err => {
                        console.error('Gagal menyalin: ', err);
                    });
                });
            }
        });
    </script>
</body>

</html>
