<div>
    <div>
        <div>
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2">
                            <i class="bi bi-tags mr-2"></i>Categories
                        </h1>
                        <p class="text-slate-400">Manage and organize all competition categories.</p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all w-full md:w-auto">
                        <i class="bi bi-plus-lg"></i>
                        Add New Category
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            @if (session()->has('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                    <i class="bi bi-check-circle text-green-400 text-xl"></i>
                    <span class="text-green-400">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-red-400 text-xl"></i>
                    <span class="text-red-400">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filters Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            placeholder="Search categories...">
                    </div>
                    <div>
                        <select wire:model.live="perPage"
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Mobile Card View (Visible on small screens) -->
            <div class="grid grid-cols-1 gap-6 md:hidden mb-6">
                @forelse ($categories as $category)
                    <div
                        class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-5 space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-white text-lg mb-1">{{ $category->name }}</h3>
                                <p class="text-xs text-slate-500">ID: {{ $category->id }}</p>
                            </div>
                            <span class="text-xs text-slate-400">{{ $category->created_at->format('M d, Y') }}</span>
                        </div>

                        <p class="text-sm text-slate-400 line-clamp-3">{{ $category->description }}</p>

                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-700/50">
                            <!-- View Button -->
                            <a href="{{ route('admin.categories.view', $category) }}"
                                class="p-2 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 transition flex-1 text-center"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Edit Button -->
                            @if (auth()->user()->role !== 'qualifier' || $category->created_by === auth()->id())
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="p-2 rounded-lg bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 border border-yellow-500/30 transition flex-1 text-center"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Delete Button -->
                                <button onclick="confirmDeleteCategory({{ $category->id }})"
                                    class="p-2 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 transition flex-1 text-center"
                                    title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-slate-800/50 rounded-2xl border border-slate-700">
                        <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                        <p class="text-slate-400 text-lg mb-2">No categories found.</p>
                        @if ($search)
                            <p class="text-slate-500 text-sm">Try adjusting your search criteria.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (Hidden on small screens) -->
            <div
                class="hidden md:block bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-900/50 border-b border-slate-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Description</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Created At</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/50">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-white font-semibold">{{ $category->id }}</td>
                                    <td class="px-6 py-4 text-white font-medium">{{ $category->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-400 text-sm truncate block max-w-md">
                                            {{ Str::limit($category->description, 100) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        {{ $category->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.categories.view', $category) }}"
                                                class="p-2 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 transition"
                                                title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            @if (auth()->user()->role !== 'qualifier' || $category->created_by === auth()->id())
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="p-2 rounded-lg bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 border border-yellow-500/30 transition"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <button onclick="confirmDeleteCategory({{ $category->id }})"
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
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                                        <p class="text-slate-400 text-lg mb-2">No categories found.</p>
                                        @if ($search)
                                            <p class="text-slate-500 text-sm">Try adjusting your search criteria.</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-700">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-slate-400">
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of
                                {{ $categories->total() }} results
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Previous Button --}}
                                @if ($categories->onFirstPage())
                                    <span class="px-3 py-2 rounded-lg bg-slate-800 text-slate-600 cursor-not-allowed">
                                        <i class="bi bi-chevron-left"></i>
                                    </span>
                                @else
                                    <button wire:click="previousPage"
                                        class="px-3 py-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-indigo-500 hover:text-white transition">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                    @if ($page == $categories->currentPage())
                                        <span class="px-4 py-2 rounded-lg gradient-primary text-white font-semibold">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white transition">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                @if ($categories->hasMorePages())
                                    <button wire:click="nextPage"
                                        class="px-3 py-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-indigo-500 hover:text-white transition">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                @else
                                    <span class="px-3 py-2 rounded-lg bg-slate-800 text-slate-600 cursor-not-allowed">
                                        <i class="bi bi-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteCategory(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kategori ini akan dihapus secara permanen!",
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
                    @this.call('delete', id);
                }
            });
        }

        window.addEventListener('category-deleted', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Kategori berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0',
            });
        });

        window.addEventListener('category-delete-failed', event => {
            Swal.fire({
                title: 'Gagal!',
                text: event.detail.message || 'Gagal menghapus kategori.',
                icon: 'error',
                confirmButtonText: 'OK',
                background: '#1e293b',
                color: '#e2e8f0',
            });
        });
    </script>

    <style>
        /* Light theme adjustments */
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
