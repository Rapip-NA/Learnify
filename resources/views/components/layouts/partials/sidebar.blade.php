<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-slate-800 to-slate-900 border-r border-slate-700 z-40 transition-all duration-300 flex flex-col">
    <!-- Sidebar Header -->
    <div class="flex-shrink-0 p-6 border-b border-slate-700">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center glow-pulse group-hover:scale-110 transition-transform">
                    <i class="bi bi-book text-white text-xl"></i>
                </div>
                <span
                    class="font-bold text-xl text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text">Learnify</span>
            </a>

            <!-- Mobile Close Button -->
            <button onclick="toggleSidebar(event)" class="lg:hidden text-slate-400 hover:text-white transition">
                <i class="bi bi-x text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav
        class="flex-1 overflow-y-auto p-4 space-y-1 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">
        @if (Auth::user()->role === 'admin')
            <!-- Admin Menu -->
            <div class="space-y-1">
                <p class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-grid-fill text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </div>

            <div class="space-y-1 mt-6">
                <p class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Main Menu</p>

                <a href="{{ route('admin.competitions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.competitions*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-trophy text-lg"></i>
                    <span class="font-medium">Competitions</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.categories*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-tags text-lg"></i>
                    <span class="font-medium">Category</span>
                </a>

                <a href="{{ route('admin.questions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.questions*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-card-checklist text-lg"></i>
                    <span class="font-medium">Question</span>
                </a>

                <a href="{{ route('admin.badges.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.badges*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-award text-lg"></i>
                    <span class="font-medium">Badges</span>
                </a>
            </div>

            <div class="space-y-1 mt-6">
                <p class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">List Anggota</p>

                <a href="{{ route('admin.peserta.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.peserta*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-people-fill text-lg"></i>
                    <span class="font-medium">Peserta</span>
                </a>

                <a href="{{ route('admin.qualifier.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.qualifier*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-people-fill text-lg"></i>
                    <span class="font-medium">Qualifier</span>
                </a>
            </div>

            <div class="space-y-1 mt-6">
                <p class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pages</p>

                <a href="{{ route('global.leaderboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('global.leaderboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-bar-chart-fill text-lg"></i>
                    <span class="font-medium">Leaderboard</span>
                </a>

                {{-- <a href="{{ route('admin.analytics') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.analytics') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-graph-up text-lg"></i>
                    <span class="font-medium">Analytics</span>
                </a> --}}
            </div>
        @elseif (Auth::user()->role === 'peserta')
            <!-- Peserta Menu -->
            <div class="space-y-1">
                <a href="{{ route('peserta.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('peserta.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-grid-fill text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('peserta.competitions.list') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('peserta.competitions*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-trophy-fill text-lg"></i>
                    <span class="font-medium">Competitions</span>
                </a>

                <a href="{{ route('peserta.my-badges') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('peserta.my-badges') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-award-fill text-lg"></i>
                    <span class="font-medium">My Badges</span>
                </a>

                <a href="{{ route('global.leaderboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('global.leaderboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-bar-chart-fill text-lg"></i>
                    <span class="font-medium">Leaderboard</span>
                </a>
            </div>
        @else
            <!-- Qualifier Menu -->
            <div class="space-y-1">
                <a href="{{ route('qualifier.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('qualifier.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-grid-fill text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.competitions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.competitions*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-trophy text-lg"></i>
                    <span class="font-medium">Competitions</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('admin.categories*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-tags text-lg"></i>
                    <span class="font-medium">Category</span>
                </a>

                <a href="{{ route('qualifier.questions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('qualifier.questions*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-card-checklist text-lg"></i>
                    <span class="font-medium">Bank Soal</span>
                </a>

                <a href="{{ route('qualifier.answer-validation') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('qualifier.answer-validation') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-check2-square text-lg"></i>
                    <span class="font-medium">Validasi Essay</span>
                </a>

                <a href="{{ route('global.leaderboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all {{ request()->routeIs('global.leaderboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : '' }}">
                    <i class="bi bi-bar-chart-fill text-lg"></i>
                    <span class="font-medium">Leaderboard</span>
                </a>
            </div>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="flex-shrink-0 p-4 border-t border-slate-700">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800/50">
            <div class="w-10 h-10 rounded-full gradient-accent flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>
    </div>
</aside>

<style>
    /* Custom Scrollbar for Sidebar */
    #sidebar nav::-webkit-scrollbar {
        width: 6px;
    }

    #sidebar nav::-webkit-scrollbar-track {
        background: rgba(30, 41, 59, 0.3);
        border-radius: 10px;
    }

    #sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(100, 116, 139, 0.5);
        border-radius: 10px;
    }

    #sidebar nav::-webkit-scrollbar-thumb:hover {
        background: rgba(100, 116, 139, 0.8);
    }

    /* Firefox scrollbar */
    #sidebar nav {
        scrollbar-width: thin;
        scrollbar-color: rgba(100, 116, 139, 0.5) rgba(30, 41, 59, 0.3);
    }

    /* Light theme for sidebar */
    body.light-theme #sidebar {
        background: linear-gradient(to bottom, #ffffff, #f8fafc);
        border-right-color: #e2e8f0;
    }

    body.light-theme #sidebar .border-slate-700 {
        border-color: #e2e8f0 !important;
    }

    body.light-theme #sidebar .text-slate-300 {
        color: #64748b !important;
    }

    body.light-theme #sidebar .text-slate-500 {
        color: #94a3b8 !important;
    }

    body.light-theme #sidebar .text-slate-400 {
        color: #94a3b8 !important;
    }

    body.light-theme #sidebar .hover\:bg-slate-800\/50:hover {
        background-color: rgba(241, 245, 249, 0.5) !important;
    }

    body.light-theme #sidebar a:hover .text-slate-300 {
        color: #0f172a !important;
    }

    body.light-theme #sidebar .bg-slate-800\/50 {
        background-color: rgba(241, 245, 249, 0.8) !important;
    }

    /* Light theme scrollbar */
    body.light-theme #sidebar nav::-webkit-scrollbar-track {
        background: rgba(226, 232, 240, 0.3);
    }

    body.light-theme #sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.5);
    }

    body.light-theme #sidebar nav::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.8);
    }

    body.light-theme #sidebar nav {
        scrollbar-color: rgba(148, 163, 184, 0.5) rgba(226, 232, 240, 0.3);
    }
</style>
