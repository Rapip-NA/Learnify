<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnify Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                transform: translateY(-10px);
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

        .blob {
            animation: blob 7s infinite;
            position: absolute;
            opacity: 0.1;
            filter: blur(40px);
            z-index: 0;
        }

        /* Dark Theme */
        body.dark-theme {
            background-color: #020617;
        }

        body.dark-theme .blob {
            opacity: 0.1;
        }

        /* Light Theme */
        body.light-theme {
            background: linear-gradient(to bottom right, #f8fafc, #ffffff, #dbeafe);
        }

        body.light-theme .blob {
            opacity: 0.08;
        }

        /* Sidebar responsive */
        @media (max-width: 1024px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0 !important;
            }
        }

        /* Smooth transitions */
        #sidebar {
            transition: transform 0.3s ease;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        body.dark-theme ::-webkit-scrollbar-track {
            background: rgb(15 23 42);
        }

        body.dark-theme ::-webkit-scrollbar-thumb {
            background: rgb(51 65 85);
            border-radius: 4px;
        }

        body.light-theme ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        body.light-theme ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* Global Light Theme Overrides */
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
        body.light-theme .to-slate-950,
        body.light-theme .bg-slate-800\/50,
        body.light-theme .bg-slate-900\/50 {
            background-color: rgba(241, 245, 249, 0.65) !important;
            background: rgba(241, 245, 249, 0.65) !important;
        }

        body.light-theme .border-slate-700,
        body.light-theme .border-slate-800,
        body.light-theme .divide-slate-700,
        body.light-theme .divide-slate-700\/50,
        body.light-theme .divide-y {
            border-color: #cbd5e1 !important;
        }

        body.light-theme .hover\:text-white:hover {
            color: #4f46e5 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-950 dark-theme">
    <!-- Animated background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob w-96 h-96 rounded-full gradient-primary" style="top: -100px; left: -100px;"></div>
        <div class="blob w-96 h-96 rounded-full gradient-accent" style="top: 50%; right: -100px; animation-delay: 2s;">
        </div>
        <div class="blob w-80 h-80 rounded-full bg-cyan-500" style="bottom: 0; left: 50%; animation-delay: 4s;"></div>
    </div>

    <!-- Sidebar -->
    @include('components.layouts.partials.sidebar')

    <div class="flex min-h-screen relative z-10">
        <!-- Main Content Wrapper -->
        <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 lg:ml-64">
            <!-- Navbar -->
            @include('components.layouts.partials.navbar')

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            @include('components.layouts.partials.footer')
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <button id="theme-toggle"
        class="fixed bottom-6 right-6 w-14 h-14 rounded-full gradient-primary shadow-lg hover:shadow-xl transition-all hover:scale-110 flex items-center justify-center z-50">
        <!-- Sun Icon (Light Mode) -->
        <svg id="sun-icon" class="w-6 h-6 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
        <!-- Moon Icon (Dark Mode) -->
        <svg id="moon-icon" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"
        onclick="toggleSidebar()"></div>

    <!-- Theme Toggle Script -->
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        const body = document.body;

        // Check for saved theme preference or default to 'dark'
        const currentTheme = localStorage.getItem('theme') || 'dark';

        // Apply theme on page load
        function applyTheme(theme) {
            if (theme === 'light') {
                body.classList.remove('dark-theme', 'bg-slate-950');
                body.classList.add('light-theme');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme', 'bg-slate-950');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }

        applyTheme(currentTheme);

        // Toggle theme
        themeToggle?.addEventListener('click', () => {
            if (body.classList.contains('dark-theme')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Sidebar toggle function
        function toggleSidebar(e) {
            // Stop propagation if event exists to prevent immediate closing by document listener
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('show');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('[onclick*="toggleSidebar"]');

            // If screen is small and sidebar is shown
            if (window.innerWidth < 1024 && sidebar.classList.contains('show')) {
                // If the click is NOT inside the sidebar
                if (!sidebar.contains(e.target)) {
                    // Close sidebar logic directly here to avoid circular dependency
                    const overlay = document.getElementById('sidebar-overlay');
                    sidebar.classList.remove('show');
                    overlay.classList.add('hidden');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
