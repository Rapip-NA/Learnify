<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnify - Platform Kompetisi Pembelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Added more sophisticated animations and visual effects */
        .gradient-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        }

        /* Added floating animation for hero section */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
            }

            50% {
                box-shadow: 0 0 40px rgba(139, 92, 246, 0.8);
            }
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        .glow-pulse {
            animation: glow-pulse 2s ease-in-out infinite;
        }

        .slide-in {
            animation: slide-in 0.6s ease-out forwards;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
        }

        /* Enhanced card hover with gradient overlay effect */
        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
            z-index: 1;
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 30px 60px rgba(99, 102, 241, 0.2);
        }

        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-glow:hover::after {
            left: 100%;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
            border-radius: 2px;
            animation: shimmer 3s infinite;
            background-size: 1000px 100%;
        }

        /* Added blob animation for background elements */
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .blob {
            animation: blob 7s infinite;
            position: absolute;
            opacity: 0.1;
            filter: blur(40px);
            z-index: 0;
        }

        /* Added ribbon badge for featured competitions */
        .ribbon {
            position: absolute;
            top: 20px;
            right: -35px;
            width: 200px;
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            text-align: center;
            line-height: 40px;
            color: white;
            font-weight: bold;
            transform: rotate(45deg);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
            font-size: 14px;
            z-index: 10;
        }

        /* Enhanced counter animation */
        @keyframes count {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .stat-number {
            animation: count 1s ease-out;
        }

        /* Added text gradient animation */
        .text-gradient-animated {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899, #6366f1);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s infinite;
        }

        /* Dark Theme (Default) */
        body.dark-theme {
            background-color: #020617;
        }

        body.dark-theme nav {
            background-color: rgba(2, 6, 23, 0.8);
            border-bottom-color: rgb(30 41 59);
        }

        body.dark-theme .blob {
            opacity: 0.1;
        }

        /* Light Theme */
        body.light-theme {
            background: linear-gradient(to bottom right, #f8fafc, #ffffff, #dbeafe);
        }

        body.light-theme nav {
            background-color: rgba(255, 255, 255, 0.9);
            border-bottom-color: #e2e8f0;
        }

        body.light-theme nav a,
        body.light-theme nav button {
            color: #334155;
        }

        body.light-theme nav a:hover,
        body.light-theme nav button:hover {
            color: #0f172a;
        }

        body.light-theme .text-white {
            color: #0f172a !important;
        }

        body.light-theme .text-slate-200 {
            color: #1e293b !important;
        }

        body.light-theme .text-slate-300 {
            color: #334155 !important;
        }

        body.light-theme .text-slate-400 {
            color: #475569 !important;
        }

        body.light-theme .text-slate-500 {
            color: #64748b !important;
        }

        body.light-theme .bg-slate-800,
        body.light-theme .bg-slate-900,
        body.light-theme .bg-slate-950,
        body.light-theme .from-slate-800,
        body.light-theme .to-slate-900,
        body.light-theme .from-slate-900,
        body.light-theme .to-slate-950 {
            background-color: rgba(241, 245, 249, 0.65) !important;
            background: rgba(241, 245, 249, 0.65) !important;
        }

        body.light-theme .card-hover {
            background: white !important;
        }

        body.light-theme .border-slate-700,
        body.light-theme .border-slate-800 {
            border-color: #cbd5e1 !important;
        }

        body.light-theme .hover\:text-white:hover {
            color: #4f46e5 !important;
        }

        body.light-theme .card-hover:hover {
            box-shadow: 0 30px 60px rgba(79, 70, 229, 0.15);
        }

        body.light-theme footer {
            background-color: #f8fafc;
            border-top-color: #e2e8f0;
        }

        body.light-theme .blob {
            opacity: 0.08;
        }

        body.light-theme #theme-toggle {
            border-color: #cbd5e1;
        }

        body.light-theme #theme-toggle:hover {
            border-color: #6366f1;
        }

        body.light-theme #theme-toggle svg {
            color: #64748b;
        }
    </style>
</head>

<body class="bg-slate-950 dark-theme">
    <!-- Added animated background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob w-96 h-96 rounded-full gradient-primary" style="top: -100px; left: -100px;"></div>
        <div class="blob w-96 h-96 rounded-full gradient-accent" style="top: 50%; right: -100px; animation-delay: 2s;">
        </div>
        <div class="blob w-80 h-80 rounded-full bg-cyan-500" style="bottom: 0; left: 50%; animation-delay: 4s;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav
        class="fixed top-0 w-full bg-slate-950 bg-opacity-80 backdrop-blur-md shadow-lg z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2 relative z-10">
                    <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center glow-pulse">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <span
                        class="font-bold text-lg sm:text-xl text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text">Learnify</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 sm:gap-4 relative z-10">
                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle"
                        class="w-10 h-10 flex items-center justify-center border-2 border-slate-700 hover:border-indigo-500 rounded-lg transition-all hover:shadow-lg">
                        <!-- Sun Icon (Light Mode) -->
                        <svg id="sun-icon" class="w-5 h-5 text-slate-400 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <!-- Moon Icon (Dark Mode) -->
                        <svg id="moon-icon" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                    </button>

                    <a href="{{ route('login') }}"
                        class="hidden sm:block text-slate-400 hover:text-white transition font-medium text-sm lg:text-base">Login</a>
                    <a href="{{ route('register') }}"
                        class="gradient-primary text-white px-4 sm:px-6 py-2 rounded-full text-sm sm:text-base font-semibold btn-glow hover:shadow-lg transition shadow-lg whitespace-nowrap">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 sm:pt-32 lg:pt-40 pb-16 sm:pb-24 lg:pb-32 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-6 sm:space-y-8">
                <div class="space-y-6 sm:space-y-8 flex flex-col items-center justify-center">
                    <div class="slide-in text-center">
                        <h1
                            class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-black text-white leading-tight text-gradient-animated px-2">
                            Kompetisi Pembelajaran yang Memukau
                        </h1>

                        <p
                            class="text-base sm:text-lg lg:text-xl text-slate-300 leading-relaxed mt-4 sm:mt-6 max-w-3xl mx-auto px-4">
                            Bergabunglah dengan ribuan peserta dari seluruh Indonesia. Raih hadiah fantastis, perluas
                            jaringan, dan tunjukkan potensi terbaikmu.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 slide-in w-full sm:w-auto px-4"
                        style="animation-delay: 0.1s">
                        <a href="#kompetisi"
                            class="gradient-primary text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold text-base sm:text-lg btn-glow hover:shadow-2xl transition shadow-lg text-center">
                            ✨ Mulai Kompetisi
                        </a>
                        <a href="#tentang"
                            class="border-2 border-indigo-500 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold text-base sm:text-lg hover:bg-indigo-500 hover:bg-opacity-10 transition backdrop-blur-sm text-center">
                            📚 Pelajari Lebih
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6 pt-4 sm:pt-8 slide-in"
                    style="animation-delay: 0.2s">
                    <div
                        class="bg-slate-800 bg-opacity-50 border border-slate-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm hover:border-indigo-500 transition text-center">
                        <div
                            class="text-2xl sm:text-3xl lg:text-4xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text stat-number">
                            {{ $stats['active_participants'] }}</div>
                        <div class="text-xs sm:text-sm text-slate-400 mt-1">Peserta Aktif</div>
                    </div>
                    <div
                        class="bg-slate-800 bg-opacity-50 border border-slate-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm hover:border-pink-500 transition text-center">
                        <div
                            class="text-2xl sm:text-3xl lg:text-4xl font-bold text-transparent bg-gradient-to-r from-pink-400 to-rose-400 bg-clip-text stat-number">
                            {{ $stats['qualifiers'] }}</div>
                        <div class="text-xs sm:text-sm text-slate-400 mt-1">Penguji</div>
                    </div>
                    <div
                        class="bg-slate-800 bg-opacity-50 border border-slate-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm hover:border-cyan-500 transition text-center">
                        <div
                            class="text-2xl sm:text-3xl lg:text-4xl font-bold text-transparent bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text stat-number">
                            {{ $stats['competitions'] }}</div>
                        <div class="text-xs sm:text-sm text-slate-400 mt-1">Kompetisi</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Daftar Kompetisi Section -->
    <section id="kompetisi" class="py-16 sm:py-24 lg:py-32 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12 sm:mb-16 lg:mb-20 space-y-3 sm:space-y-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white px-4">
                    <span class="section-title">Kompetisi Terbaru</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-slate-300 max-w-2xl mx-auto px-4">
                    Pilih kompetisi yang sesuai dengan minat dan kemampuanmu. Setiap kompetisi menawarkan kesempatan
                    luar biasa.
                </p>
            </div>

            <!-- Kompetisi Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @forelse($competitions as $index => $competition)
                    <!-- Competition Card -->
                    <div
                        class="card-hover bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 space-y-4 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-indigo-500 opacity-0 group-hover:opacity-10 rounded-full blur-3xl transition-all duration-500">
                        </div>

                        <div
                            class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center text-2xl glow-pulse relative z-10">
                            {{ $index === 0 ? '💻' : ($index === 1 ? '🎨' : ($index === 2 ? '📊' : ($index === 3 ? '✍️' : ($index === 4 ? '💡' : '🎬')))) }}
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black text-white">{{ $competition->title }}</h3>
                            <p class="text-slate-400 mt-2 line-clamp-2">{{ $competition->description }}</p>
                        </div>

                        <div class="space-y-3 py-4 border-y border-slate-700 relative z-10">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Kategori</span>
                                <span class="font-bold text-white">{{ $competition->category->name ?? 'Umum' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Mulai</span>
                                <span
                                    class="font-bold text-white">{{ $competition->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Berakhir</span>
                                <span class="font-bold text-white">{{ $competition->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2 relative z-10">
                            <div
                                class="bg-indigo-500 bg-opacity-20 text-indigo-300 px-3 py-1 rounded-full text-xs font-semibold border border-indigo-500 border-opacity-30">
                                {{ $competition->status }}
                            </div>
                        </div>

                        <a href="{{ route('register') }}"
                            class="block w-full gradient-primary text-white py-3 rounded-xl font-bold hover:shadow-xl transition relative z-10 text-center">
                            Ikuti Kompetisi →
                        </a>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-16">
                        <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Belum Ada Kompetisi</h3>
                        <p class="text-slate-400">Belum ada kompetisi aktif saat ini. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            @if ($competitions->count() > 0)
                <div class="text-center mt-20 relative z-10">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 rounded-full font-bold text-lg border-2 border-indigo-500 text-white hover:gradient-primary transition inline-block">
                        Lihat Semua Kompetisi ({{ $competitions->count() }}+) →
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang"
        class="py-16 sm:py-24 lg:py-32 px-4 sm:px-6 lg:px-8 relative z-10 bg-slate-900 bg-opacity-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 sm:mb-16 lg:mb-20 space-y-3 sm:space-y-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white px-4">
                    <span class="section-title">Tentang Learnify</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-slate-300 max-w-3xl mx-auto px-4">
                    Learnify adalah platform kompetisi pembelajaran yang dirancang untuk membantu peserta mengembangkan
                    keterampilan mereka melalui berbagai kompetisi yang menantang dan menarik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <div
                    class="card-hover bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 sm:p-8 space-y-3 sm:space-y-4">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 gradient-primary rounded-xl flex items-center justify-center text-2xl sm:text-3xl">
                        🎯
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">Kompetisi Berkualitas</h3>
                    <p class="text-sm sm:text-base text-slate-400">Kompetisi dirancang oleh para ahli untuk memastikan
                        pembelajaran yang
                        efektif dan menyenangkan.</p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 sm:p-8 space-y-3 sm:space-y-4">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 gradient-accent rounded-xl flex items-center justify-center text-2xl sm:text-3xl">
                        🏅
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">Hadiah Menarik</h3>
                    <p class="text-sm sm:text-base text-slate-400">Dapatkan hadiah menarik dan sertifikat untuk setiap
                        kompetisi yang
                        diikuti.</p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 sm:p-8 space-y-3 sm:space-y-4">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-cyan-600 rounded-xl flex items-center justify-center text-2xl sm:text-3xl">
                        🌐</div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">Komunitas Global</h3>
                    <p class="text-sm sm:text-base text-slate-400">Bergabung dengan ribuan peserta dari berbagai negara
                        dan perluas jaringan
                        Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-8 sm:py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-3 sm:mb-4">
                        <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold">L</span>
                        </div>
                        <span class="font-bold text-white text-base sm:text-lg">Learnify</span>
                    </div>
                    <p class="text-slate-400 text-xs sm:text-sm">Platform kompetisi pembelajaran terdepan di Indonesia
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-2 sm:mb-3 text-sm sm:text-base">Platform</h4>
                    <ul class="space-y-1 sm:space-y-2 text-slate-400 text-xs sm:text-sm">
                        <li><a href="#kompetisi" class="hover:text-white transition">Kompetisi</a></li>
                        {{-- <li><a href="{{ route('global.leaderboard') }}"
                                class="hover:text-white transition">Leaderboard</a></li> --}}
                        <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-2 sm:mb-3 text-sm sm:text-base">Perusahaan</h4>
                    <ul class="space-y-1 sm:space-y-2 text-slate-400 text-xs sm:text-sm">
                        <li><a href="#" class="hover:text-white transition">Tentang</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-2 sm:mb-3 text-sm sm:text-base">Legal</h4>
                    <ul class="space-y-1 sm:space-y-2 text-slate-400 text-xs sm:text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t border-slate-800 pt-6 sm:pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
                <p class="text-slate-500 text-xs sm:text-sm text-center sm:text-left">© 2025 Learnify. All rights
                    reserved.</p>
                <div class="flex gap-3 sm:gap-4">
                    <a href="#"
                        class="text-slate-400 hover:text-white transition text-xs sm:text-sm">Twitter</a>
                    <a href="#"
                        class="text-slate-400 hover:text-white transition text-xs sm:text-sm">Facebook</a>
                    <a href="#"
                        class="text-slate-400 hover:text-white transition text-xs sm:text-sm">Instagram</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Theme Toggle Script -->
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        const body = document.body;

        // Check for saved theme preference or default to 'dark'
        const currentTheme = localStorage.getItem('theme') || 'dark';

        // Apply theme on page load
        if (currentTheme === 'light') {
            body.classList.remove('dark-theme');
            body.classList.add('light-theme');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            body.classList.remove('light-theme');
            body.classList.add('dark-theme');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        }

        // Toggle theme
        themeToggle?.addEventListener('click', () => {
            if (body.classList.contains('dark-theme')) {
                body.classList.remove('dark-theme');
                body.classList.add('light-theme');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>

</html>
