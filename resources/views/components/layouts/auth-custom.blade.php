<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnify - Masuk / Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Gradient definitions */
        .gradient-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        }

        /* Animations */
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

        .float {
            animation: float 3s ease-in-out infinite;
        }

        .glow-pulse {
            animation: glow-pulse 2s ease-in-out infinite;
        }

        .slide-in {
            animation: slide-in 0.6s ease-out forwards;
        }

        .blob {
            animation: blob 7s infinite;
            position: absolute;
            opacity: 0.1;
            filter: blur(40px);
            z-index: 0;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
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

        body.dark-theme .auth-card {
            background: linear-gradient(to bottom right, rgb(30 41 59 / 0.8), rgb(15 23 42 / 0.8));
            border-color: rgb(51 65 85);
        }

        body.dark-theme .form-input {
            background-color: rgb(30 41 59);
            border-color: rgb(51 65 85);
            color: white;
        }

        body.dark-theme .form-input::placeholder {
            color: rgb(148 163 184);
        }

        body.dark-theme .form-input:focus {
            background-color: rgb(15 23 42);
            border-color: rgb(99 102 241);
        }

        body.dark-theme .form-label {
            color: rgb(226 232 240);
        }

        body.dark-theme .text-muted {
            color: rgb(148 163 184) !important;
        }

        body.dark-theme .text-secondary {
            color: white !important;
        }

        body.dark-theme .icon-color {
            color: rgb(148 163 184);
        }

        /* Light Theme */
        body.light-theme {
            background: linear-gradient(to bottom right, #f8fafc, #ffffff, #dbeafe);
        }

        body.light-theme nav {
            background-color: rgba(255, 255, 255, 0.9);
            border-bottom-color: #e2e8f0;
        }

        body.light-theme nav a {
            color: #64748b;
        }

        body.light-theme nav a:hover {
            color: #6366f1;
        }

        body.light-theme .blob {
            opacity: 0.08;
        }

        body.light-theme .auth-card {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgb(226 232 240);
        }

        body.light-theme .form-input {
            background-color: rgb(248 250 252);
            border-color: rgb(226 232 240);
            color: rgb(15 23 42);
        }

        body.light-theme .form-input::placeholder {
            color: rgb(148 163 184);
        }

        body.light-theme .form-input:focus {
            background-color: white;
            border-color: rgb(99 102 241);
        }

        body.light-theme .form-label {
            color: rgb(15 23 42);
        }

        body.light-theme .text-muted {
            color: rgb(100 116 139) !important;
        }

        body.light-theme .text-secondary {
            color: rgb(15 23 42) !important;
        }

        body.light-theme .icon-color {
            color: rgb(156 163 175);
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

        body.light-theme .hover\:text-white:hover {
            color: #4f46e5 !important;
        }
    </style>
</head>

<body class="bg-slate-950 dark-theme">
    <!-- Animated background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob w-96 h-96 rounded-full gradient-primary" style="top: -100px; left: -100px;"></div>
        <div class="blob w-96 h-96 rounded-full gradient-accent" style="top: 50%; right: -100px; animation-delay: 2s;">
        </div>
        <div class="blob w-80 h-80 rounded-full bg-cyan-500" style="bottom: 0; left: 50%; animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-slate-950 bg-opacity-80 backdrop-blur-md z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16 lg:h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 sm:gap-3 group">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 gradient-primary rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform glow-pulse">
                        <span class="text-white font-bold text-base sm:text-lg">L</span>
                    </div>
                    <span
                        class="text-xl sm:text-2xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text">Learnify</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle"
                        class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center border-2 border-slate-700 hover:border-indigo-500 rounded-lg transition-all hover:shadow-lg">
                        <!-- Sun Icon (Light Mode) -->
                        <svg id="sun-icon" class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 hidden" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <!-- Moon Icon (Dark Mode) -->
                        <svg id="moon-icon" class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                    </button>

                    <!-- Back to Home -->
                    <a href="/"
                        class="text-slate-400 hover:text-white transition-colors font-medium text-xs sm:text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Kembali ke Beranda</span>
                        <span class="sm:hidden">Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center pt-20 pb-12 sm:pt-24 sm:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 transition-all duration-300">
            {{ $slot }}
        </div>
    </section>

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
