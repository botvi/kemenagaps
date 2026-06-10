<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kemenhaj Kuansing</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        /* Floating Chat Animation */
        .chat-btn-float {
            animation: bounce-float 3s infinite ease-in-out;
        }
        @keyframes bounce-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="text-2xl font-bold text-brand-600 flex items-center gap-2">
                        <i class="fa-solid fa-kaaba"></i>
                        <span>Kemenhaj Kuansing</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8 items-center">
                    @auth
                        @if(Auth::user()->role == 'superadmin')
                            {{-- Superadmin Navbar --}}
                            <a href="{{ route('home') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-600 font-bold' : '' }}">Beranda</a>
                            <a href="{{ route('dashboard-superadmin') }}" class="bg-brand-600 text-white px-6 py-2 rounded-full font-medium hover:bg-brand-700 transition-colors shadow-lg shadow-brand-500/30">
                                Dashboard
                            </a>
                        @elseif(Auth::user()->calonJemaahs()->exists())
                            {{-- Navbar Calon Jemaah Terdaftar: hanya 3 menu --}}
                            <a href="{{ route('jemaah.dashboard') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('jemaah.dashboard') ? 'text-brand-600 font-bold' : '' }}">Dashboard</a>
                            <a href="{{ route('user.informasi') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.informasi*') ? 'text-brand-600 font-bold' : '' }}">Informasi</a>
                            <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full font-medium transition-colors shadow-lg shadow-red-500/30 flex items-center gap-2">
                                <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i> Logout
                            </a>
                        @else
                            {{-- Navbar User Biasa --}}
                            <a href="{{ route('home') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-600 font-bold' : '' }}">Beranda</a>
                            <a href="{{ route('user.paket') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.paket*') ? 'text-brand-600 font-bold' : '' }}">Paket Haji</a>
                            <a href="{{ route('user.informasi') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.informasi*') ? 'text-brand-600 font-bold' : '' }}">Informasi</a>
                            <a href="{{ route('user.ulasan') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.ulasan*') ? 'text-brand-600 font-bold' : '' }}">Ulasan</a>
                            <a href="{{ route('user.jadwal-manasik') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.jadwal-manasik*') ? 'text-brand-600 font-bold' : '' }}">Jadwal Manasik</a>
                            <a href="{{ route('user.profil') }}" class="flex items-center gap-2 text-gray-700 hover:text-brand-600 font-medium transition-colors">
                                <img src="{{ Auth::user()->foto_profile ? asset(Auth::user()->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=14b8a6&color=fff' }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
                            </a>
                        @endif
                    @else
                        {{-- Navbar Guest --}}
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-600 font-bold' : '' }}">Beranda</a>
                        <a href="{{ route('user.paket') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.paket*') ? 'text-brand-600 font-bold' : '' }}">Paket Haji</a>
                        <a href="{{ route('user.informasi') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.informasi*') ? 'text-brand-600 font-bold' : '' }}">Informasi</a>
                        <a href="{{ route('user.ulasan') }}" class="text-gray-700 hover:text-brand-600 font-medium transition-colors {{ request()->routeIs('user.ulasan*') ? 'text-brand-600 font-bold' : '' }}">Ulasan</a>
                        <a href="{{ route('login') }}" class="bg-brand-600 text-white px-6 py-2 rounded-full font-medium hover:bg-brand-700 transition-colors shadow-lg shadow-brand-500/30">
                            Masuk
                        </a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-brand-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-xl absolute w-full">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 flex flex-col">
                @auth
                    @if(Auth::user()->role == 'superadmin')
                        {{-- Superadmin Mobile --}}
                        <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-gray-50 text-brand-600' : '' }}">Beranda</a>
                        <a href="{{ route('dashboard-superadmin') }}" class="text-brand-600 font-bold hover:bg-gray-50 block px-3 py-2 rounded-md text-base">Dashboard</a>
                    @elseif(Auth::user()->calonJemaahs()->exists())
                        {{-- Calon Jemaah Mobile: hanya 3 menu --}}
                        <a href="{{ route('jemaah.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('jemaah.dashboard') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Dashboard</a>
                        <a href="{{ route('user.informasi') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.informasi*') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Informasi</a>
                        <a href="{{ route('logout') }}" class="text-red-600 font-bold hover:bg-red-50 block px-3 py-2 rounded-md text-base">Logout</a>
                    @else
                        {{-- User Biasa Mobile --}}
                        <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-gray-50 text-brand-600' : '' }}">Beranda</a>
                        <a href="{{ route('user.paket') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.paket*') ? 'bg-gray-50 text-brand-600' : '' }}">Paket Haji</a>
                        <a href="{{ route('user.informasi') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.informasi*') ? 'bg-gray-50 text-brand-600' : '' }}">Informasi</a>
                        <a href="{{ route('user.ulasan') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.ulasan*') ? 'bg-gray-50 text-brand-600' : '' }}">Ulasan</a>
                        <a href="{{ route('user.jadwal-manasik') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.jadwal-manasik*') ? 'bg-gray-50 text-brand-600' : '' }}">Jadwal Manasik</a>
                        <a href="{{ route('user.profil') }}" class="text-brand-600 font-bold hover:bg-gray-50 block px-3 py-2 rounded-md text-base">Profil Saya</a>
                    @endif
                @else
                    {{-- Guest Mobile --}}
                    <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-gray-50 text-brand-600' : '' }}">Beranda</a>
                    <a href="{{ route('user.paket') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.paket*') ? 'bg-gray-50 text-brand-600' : '' }}">Paket Haji</a>
                    <a href="{{ route('user.informasi') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.informasi*') ? 'bg-gray-50 text-brand-600' : '' }}">Informasi</a>
                    <a href="{{ route('user.ulasan') }}" class="text-gray-700 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.ulasan*') ? 'bg-gray-50 text-brand-600' : '' }}">Ulasan</a>
                    <a href="{{ route('login') }}" class="text-brand-600 font-bold hover:bg-gray-50 block px-3 py-2 rounded-md text-base">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="#" class="text-2xl font-bold text-brand-500 flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-kaaba"></i>
                        <span>Kemenhaj Kuansing</span>
                    </a>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Melayani dengan sepenuh hati untuk wujudkan niat suci Anda ke Tanah Suci. Biro perjalanan Haji & Umrah terpercaya.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-all">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-all">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-all">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-brand-400 transition-colors">Beranda</a></li>
                        @if(!Auth::check() || !Auth::user()->calonJemaahs()->exists())
                            <li><a href="{{ route('user.paket') }}" class="text-gray-400 hover:text-brand-400 transition-colors">Paket Haji & Umrah</a></li>
                        @endif
                        <li><a href="{{ route('user.informasi') }}" class="text-gray-400 hover:text-brand-400 transition-colors">Artikel & Informasi</a></li>
                        <li><a href="{{ route('user.ulasan') }}" class="text-gray-400 hover:text-brand-400 transition-colors">Ulasan &amp; Testimoni</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Hubungi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-brand-500"></i>
                            <span class="text-gray-400">Jl. Barangan, Beringin Taluk, Kuantan Tengah, Kuantan Singingi , Riau 29566</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-brand-500"></i>
                            <span class="text-gray-400">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-brand-500"></i>
                            <span class="text-gray-400">info@alharamain.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Kemenhaj Kuansing. Hak Cipta Dilindungi.
                </p>
                <div class="flex space-x-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Chat Support Widget -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-none">
        <!-- Chat Box -->
        <div id="chat-box" class="pointer-events-auto absolute bottom-20 right-0 bg-white rounded-2xl shadow-2xl w-80 md:w-96 flex flex-col overflow-hidden transform scale-0 origin-bottom-right transition-transform duration-300 opacity-0 h-[500px]">
            <div class="bg-brand-600 p-4 text-white flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-brand-600">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold">AI Assistant</h4>
                        <p class="text-xs text-brand-100">Siap menjawab pertanyaan Anda</p>
                    </div>
                </div>
                <button id="close-chat" class="text-white hover:text-gray-200 pointer-events-auto">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>
            
            <div id="chat-messages" class="p-4 flex-grow bg-gray-50 overflow-y-auto flex flex-col gap-3 scroll-smooth">
                <div class="text-center text-xs text-gray-400 mb-2">Hari ini</div>
                
                <!-- CS Message -->
                <div class="flex gap-2">
                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 flex-shrink-0">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>
                    <div class="bg-white border border-gray-100 p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[85%]">
                        Assalamu'alaikum 🙏<br>Saya adalah Asisten AI Kemenhaj Kuansing. Anda bisa memilih pertanyaan umum di bawah, atau ketikkan pertanyaan Anda sendiri (misal: "harga haji plus", "fasilitas").
                    </div>
                </div>

                <!-- FAQ Chips Container -->
                <div id="faq-chips" class="flex flex-wrap gap-2 mt-2">
                    <!-- Dynamic FAQs will be loaded here -->
                </div>
            </div>

            <!-- Chat Form -->
            <form id="chat-form" class="p-3 bg-white border-t border-gray-100 flex items-center gap-2 flex-shrink-0">
                <input type="text" id="chat-input" placeholder="Ketik pertanyaan Anda..." class="w-full bg-gray-100 border-none rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" required>
                <button type="submit" class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center flex-shrink-0 hover:bg-brand-700 transition-colors">
                    <i class="fa-solid fa-paper-plane text-sm -ml-1"></i>
                </button>
            </form>
        </div>

        <!-- Float Button -->
        <button id="chat-toggle" class="pointer-events-auto chat-btn-float w-14 h-14 bg-green-500 rounded-full shadow-lg shadow-green-500/40 text-white flex items-center justify-center text-2xl hover:bg-green-600 hover:scale-110 transition-all focus:outline-none relative">
            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
            <i class="fa-solid fa-robot"></i>
        </button>
    </div>

    <!-- Scripts -->
    <script>
        // Navbar styling on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('bg-white', 'shadow-md');
                navbar.classList.remove('bg-transparent', 'py-2');
            } else {
                navbar.classList.remove('bg-white', 'shadow-md');
                navbar.classList.add('bg-transparent', 'py-2');
            }
        });

        // Mobile Menu Toggle
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const chatToggle = document.getElementById('chat-toggle');
        const chatBox = document.getElementById('chat-box');
        const closeChat = document.getElementById('close-chat');
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const faqChips = document.getElementById('faq-chips');

        // Load FAQs
        let faqsLoaded = false;
        async function loadFaqs() {
            if (faqsLoaded) return;
            try {
                const response = await fetch('/api/faqs');
                const faqs = await response.json();
                faqs.forEach(faq => {
                    const btn = document.createElement('button');
                    btn.className = 'bg-white border border-brand-200 text-brand-700 text-xs px-3 py-1.5 rounded-full hover:bg-brand-50 transition-colors text-left';
                    btn.innerText = faq.pertanyaan;
                    btn.onclick = () => {
                        chatInput.value = faq.pertanyaan;
                        chatForm.dispatchEvent(new Event('submit'));
                    };
                    faqChips.appendChild(btn);
                });
                faqsLoaded = true;
            } catch (e) {
                console.error("Gagal mengambil FAQ", e);
            }
        }

        function toggleChat() {
            if (chatBox.classList.contains('scale-0')) {
                chatBox.classList.remove('scale-0', 'opacity-0');
                chatBox.classList.add('scale-100', 'opacity-100');
                chatToggle.classList.remove('chat-btn-float');
                loadFaqs();
            } else {
                chatBox.classList.add('scale-0', 'opacity-0');
                chatBox.classList.remove('scale-100', 'opacity-100');
                chatToggle.classList.add('chat-btn-float');
            }
        }

        chatToggle.addEventListener('click', toggleChat);
        closeChat.addEventListener('click', toggleChat);

        // Append Message Helper
        function appendMessage(text, sender = 'bot') {
            const wrapper = document.createElement('div');
            wrapper.className = sender === 'user' ? 'flex gap-2 justify-end' : 'flex gap-2';

            let avatar = '';
            let msgClass = '';

            if (sender === 'user') {
                msgClass = 'bg-brand-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-sm max-w-[85%]';
            } else {
                avatar = `
                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 flex-shrink-0">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>
                `;
                msgClass = 'bg-white border border-gray-100 p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[85%]';
            }

            wrapper.innerHTML = `
                ${sender === 'bot' ? avatar : ''}
                <div class="${msgClass}">
                    ${text}
                </div>
            `;
            
            chatMessages.appendChild(wrapper);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Handle Chat Submit
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message
            appendMessage(message, 'user');
            chatInput.value = '';

            // Loading indicator
            const loadingId = 'loading-' + Date.now();
            const loadingWrapper = document.createElement('div');
            loadingWrapper.id = loadingId;
            loadingWrapper.className = 'flex gap-2 text-gray-400 text-xs items-center ml-10';
            loadingWrapper.innerHTML = 'AI sedang mengetik...';
            chatMessages.appendChild(loadingWrapper);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message })
                });
                
                const data = await response.json();
                
                // Remove loading
                document.getElementById(loadingId).remove();
                
                // Show reply
                appendMessage(data.reply, 'bot');
            } catch (error) {
                document.getElementById(loadingId).remove();
                appendMessage("Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi.", 'bot');
            }
        });

        // Optional: Trigger initial scroll check
        window.dispatchEvent(new Event('scroll'));
    </script>
</body>
</html>
