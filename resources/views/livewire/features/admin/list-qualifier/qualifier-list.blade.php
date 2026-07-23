<div>
    <div>
        <div>
            <div>
                <!-- Page Header -->
                <div class="mb-8">
                    <div>
                        <h1
                            class="text-2xl md:text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2 flex items-center gap-2">
                            <i class="bi bi-shield-check"></i>
                            Daftar Qualifier
                        </h1>
                        <p class="text-slate-400">Kelola qualifier yang memverifikasi soal dan jawaban</p>
                    </div>
                </div>

                <!-- Alerts -->
                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <i class="bi bi-check-circle text-green-400 text-xl"></i>
                        <span class="text-green-400">{{ session('message') }}</span>
                    </div>
                @endif

                <!-- Tabs -->
                <div class="flex border-b border-slate-700 mb-6 gap-2">
                    <button wire:click="setTab('qualifiers')"
                        class="px-4 py-2 font-semibold border-b-2 text-sm transition {{ $activeTab === 'qualifiers' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-white' }}">
                        Daftar Qualifier
                    </button>
                    <button wire:click="setTab('applications')"
                        class="px-4 py-2 font-semibold border-b-2 text-sm transition flex items-center gap-2 {{ $activeTab === 'applications' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-white' }}">
                        Pengajuan Baru
                        @if ($pendingCount > 0)
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-indigo-500 text-white">{{ $pendingCount }}</span>
                        @endif
                    </button>
                </div>

                <!-- Filters Card -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="{{ $activeTab === 'applications' ? 'Cari nama atau email pengaju...' : 'Cari nama atau email qualifier...' }}">
                        </div>
                        <div>
                            <select wire:model.live="perPage"
                                class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option value="5">5 per halaman</option>
                                <option value="10">10 per halaman</option>
                                <option value="25">25 per halaman</option>
                                <option value="50">50 per halaman</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div
                    class="hidden md:block bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-900/50 border-b border-slate-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">
                                        <button wire:click="sortBy('id')"
                                            class="flex items-center gap-1 hover:text-white transition">
                                            ID
                                            @if ($sortField === 'id')
                                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                                            @endif
                                        </button>
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">
                                        <button wire:click="sortBy('name')"
                                            class="flex items-center gap-1 hover:text-white transition">
                                            Nama
                                            @if ($sortField === 'name')
                                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                                            @endif
                                        </button>
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">
                                        <button wire:click="sortBy('email')"
                                            class="flex items-center gap-1 hover:text-white transition">
                                            Email
                                            @if ($sortField === 'email')
                                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                                            @endif
                                        </button>
                                    </th>
                                    @if ($activeTab === 'applications')
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300" colspan="2">Status</th>
                                    @else
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Soal Diverifikasi</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Jawaban Diverifikasi</th>
                                    @endif
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">
                                        <button wire:click="sortBy('created_at')"
                                            class="flex items-center gap-1 hover:text-white transition">
                                            {{ $activeTab === 'applications' ? 'Tanggal Diajukan' : 'Terdaftar' }}
                                            @if ($sortField === 'created_at')
                                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                                            @endif
                                        </button>
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-700/50">
                                @forelse($qualifiers as $q)
                                    <tr class="hover:bg-slate-800/50 transition">
                                        <td class="px-6 py-4 text-white font-semibold">{{ $q->id }}</td>
                                        <td class="px-6 py-4 text-white font-medium">{{ $q->name }}</td>
                                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $q->email }}</td>
                                        
                                        @if ($activeTab === 'applications')
                                            <td colspan="2" class="px-6 py-4 text-slate-300 text-sm">
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded-full text-xs font-semibold">
                                                    <i class="bi bi-hourglass-split"></i>
                                                    Menunggu Persetujuan
                                                </span>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                    {{ $q->verified_questions_count }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">
                                                    {{ $q->verified_participant_answers_count }}
                                                </span>
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 text-slate-300 text-sm">
                                            {{ $q->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                @if ($activeTab === 'applications')
                                                    <button wire:click="approveApplication({{ $q->id }})"
                                                        class="p-2 rounded-lg bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 transition"
                                                        title="Setujui">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <button wire:click="rejectApplication({{ $q->id }})"
                                                        class="p-2 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 transition"
                                                        title="Tolak">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin.qualifier.show', $q->id) }}" wire:navigate
                                                        class="p-2 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 transition"
                                                        title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button onclick="confirmDeleteQualifier({{ $q->id }})"
                                                        class="p-2 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 transition"
                                                        title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                                            @if ($search)
                                                <p class="text-slate-400 text-lg mb-2">Tidak ada data ditemukan untuk "{{ $search }}"</p>
                                            @else
                                                <p class="text-slate-400 text-lg">{{ $activeTab === 'applications' ? 'Belum ada pengajuan qualifier baru' : 'Belum ada qualifier terdaftar' }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden grid grid-cols-1 gap-4">
                    @forelse($qualifiers as $q)
                        <div
                            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-4 relative overflow-hidden">
                            <!-- ID Badge -->
                            <div class="absolute top-0 right-0 p-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-slate-700 text-slate-300">
                                    #{{ $q->id }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <!-- User Info -->
                                <div>
                                    <h3 class="text-white font-semibold text-lg pr-12">{{ $q->name }}</h3>
                                    <div class="flex items-center gap-2 mt-1 text-slate-400 text-sm">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $q->email }}</span>
                                    </div>
                                </div>

                                @if ($activeTab === 'applications')
                                    <div class="bg-slate-800/50 rounded-xl p-3 border border-slate-700/50">
                                        <div class="text-xs text-slate-400 mb-1">Status</div>
                                        <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                            Menunggu Persetujuan
                                        </span>
                                    </div>
                                @else
                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-2 gap-3 pb-2 border-b border-slate-700/50">
                                        <div class="bg-slate-800/50 rounded-xl p-3 text-center border border-slate-700/50">
                                            <div class="text-xs text-slate-400 mb-1">Soal Diverifikasi</div>
                                            <span
                                                class="px-2 py-1 rounded-lg text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                {{ $q->verified_questions_count }}
                                            </span>
                                        </div>
                                        <div class="bg-slate-800/50 rounded-xl p-3 text-center border border-slate-700/50">
                                            <div class="text-xs text-slate-400 mb-1">Jawaban Diverifikasi</div>
                                            <span
                                                class="px-2 py-1 rounded-lg text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">
                                                {{ $q->verified_participant_answers_count }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Meta Info -->
                                <div class="flex items-center gap-4 text-sm text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>{{ $activeTab === 'applications' ? 'Diajukan' : 'Terdaftar' }}: {{ $q->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="grid grid-cols-2 gap-3 pt-2">
                                    @if ($activeTab === 'applications')
                                        <button wire:click="approveApplication({{ $q->id }})"
                                            class="flex items-center justify-center gap-2 p-2 rounded-xl bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/30 transition text-sm font-medium">
                                            <i class="bi bi-check-lg"></i> Setujui
                                        </button>
                                        <button wire:click="rejectApplication({{ $q->id }})"
                                            class="flex items-center justify-center gap-2 p-2 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 transition text-sm font-medium">
                                            <i class="bi bi-x-lg"></i> Tolak
                                        </button>
                                    @else
                                        <a href="{{ route('admin.qualifier.show', $q->id) }}" wire:navigate
                                            class="flex items-center justify-center gap-2 p-2 rounded-xl bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 border border-blue-500/30 transition text-sm font-medium">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <button onclick="confirmDeleteQualifier({{ $q->id }})"
                                            class="flex items-center justify-center gap-2 p-2 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 transition text-sm font-medium">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-8 text-center">
                            <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                            @if ($search)
                                <p class="text-slate-400 text-lg mb-2">Tidak ada data ditemukan untuk "{{ $search }}"</p>
                            @else
                                <p class="text-slate-400 text-lg">{{ $activeTab === 'applications' ? 'Belum ada pengajuan qualifier baru' : 'Belum ada qualifier terdaftar' }}</p>
                            @endif
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div
                    class="px-4 py-4 md:px-6 md:py-4 bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl mt-4">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-slate-400 text-center md:text-left">
                            Menampilkan {{ $qualifiers->firstItem() ?? 0 }} - {{ $qualifiers->lastItem() ?? 0 }} dari
                            {{ $qualifiers->total() }} {{ $activeTab === 'applications' ? 'pengaju' : 'qualifier' }}
                        </div>
                        <div class="flex justify-center md:justify-end w-full md:w-auto">
                            {{ $qualifiers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteQualifier(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data qualifier ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#e2e8f0',
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteQualifier', id);
                }
            });
        }

        window.addEventListener('qualifier-deleted', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Qualifier berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0',
            });
        });

        window.addEventListener('qualifier-approved', event => {
            Swal.fire({
                title: 'Disetujui!',
                text: 'Pengaju telah disetujui menjadi Qualifier.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0',
            });
        });

        window.addEventListener('qualifier-rejected', event => {
            Swal.fire({
                title: 'Ditolak!',
                text: 'Pengajuan Qualifier telah ditolak.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0',
            });
        });
    </script>

    <style>
        body.light-theme .bg-gradient-to-br {
            background: white !important;
            border-color: #e2e8f0 !important;
        }

        body.light-theme .text-white {
            color: #0f172a !important;
        }

        body.light-theme .text-slate-300,
        body.light-theme .text-slate-400 {
            color: #64748b !important;
        }

        body.light-theme .border-slate-700 {
            border-color: #e2e8f0 !important;
        }

        body.light-theme .bg-slate-900 {
            background: #f8fafc !important;
        }

        body.light-theme input,
        body.light-theme select {
            background: white !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        body.light-theme .hover\:bg-slate-800\/50:hover {
            background-color: rgba(241, 245, 249, 0.5) !important;
        }

        body.light-theme .bi-inbox {
            color: #cbd5e1 !important;
        }
    </style>

</div>
