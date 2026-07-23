<div>
    <!-- Responsive Improved Version (Only Style Adjustments, No Function Changes) -->
    <div>
        <div>
            <div>
                <!-- Page Header -->
                <div class="mb-8">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-center md:text-left">
                        <div>
                            <h1
                                class="text-2xl md:text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2">
                                <i class="bi bi-patch-question mr-2"></i>Questions Management
                            </h1>
                            <p class="text-slate-400 text-sm md:text-base">Manage all competition questions and their
                                details.</p>
                        </div>
                        <a href="{{ auth()->user()->role === 'qualifier' ? route('qualifier.questions.create') : route('admin.questions.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 md:px-6 md:py-3 gradient-primary text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all w-full md:w-auto text-sm md:text-base">
                            <i class="bi bi-plus-lg"></i>
                            {{ auth()->user()->role === 'qualifier' ? 'Tambah Soal Essay' : 'Add New Question' }}
                        </a>
                    </div>
                </div>

                <!-- Alerts -->
                @if (session()->has('message'))
                    <div
                        class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3 text-sm md:text-base">
                        <i class="bi bi-check-circle text-green-400 text-xl"></i>
                        <span class="text-green-400">{{ session('message') }}</span>
                    </div>
                @endif

                <!-- Filters Card -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-4 md:p-6 mb-6">
                    <h4 class="text-lg font-bold text-white mb-4 text-center md:text-left">Filter Questions</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="lg:col-span-2">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="w-full px-4 py-2.5 md:py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-400 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="Search questions...">
                        </div>
                        <div>
                            <select wire:model.live="filterCompetition"
                                class="w-full px-4 py-2.5 md:py-3 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option value="">All Competitions</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}">{{ Str::limit($competition->title, 20) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select wire:model.live="filterCategory"
                                class="w-full px-4 py-2.5 md:py-3 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select wire:model.live="filterDifficulty"
                                class="w-full px-4 py-2.5 md:py-3 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option value="">All Difficulties</option>
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div>
                            <select wire:model.live="filterStatus"
                                class="w-full px-4 py-2.5 md:py-3 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto hidden md:block">
                        <table class="w-full text-sm md:text-base">
                            <thead class="bg-slate-900/50 border-b border-slate-700">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">ID</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">
                                        Question</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">
                                        Competition</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">
                                        Category</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">
                                        Difficulty</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">Points
                                    </th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-slate-300">Status
                                    </th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-center font-semibold text-slate-300">
                                        Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-700/50">
                                @forelse($questions as $question)
                                    <tr class="hover:bg-slate-800/50 transition">
                                        <td class="px-4 md:px-6 py-3 text-white font-semibold">{{ $question->id }}</td>
                                        <td class="px-4 md:px-6 py-3">
                                            <div class="text-white font-medium truncate max-w-[150px] md:max-w-xs">
                                                {{ Str::limit($question->question_text, 50) }}
                                            </div>
                                        </td>
                                        <td
                                            class="px-4 md:px-6 py-3 text-slate-400 text-xs md:text-sm truncate max-w-[120px] md:max-w-xs">
                                            {{ $question->competition->title ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 md:px-6 py-3 text-slate-300 text-xs md:text-sm">
                                            {{ $question->category->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 md:px-6 py-3">
                                            @if ($question->difficulty_level === 'easy')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Easy</span>
                                            @elseif($question->difficulty_level === 'medium')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Medium</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400 border border-red-500/30">Hard</span>
                                            @endif
                                        </td>
                                        <td class="px-4 md:px-6 py-3 text-white font-semibold">
                                            {{ $question->point_weight }}</td>
                                        <td class="px-4 md:px-6 py-3">
                                            @if ($question->validation_status === 'approved')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Approved</span>
                                            @elseif($question->validation_status === 'pending')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">Pending</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400 border border-red-500/30">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-4 md:px-6 py-3">
                                            <div class="flex items-center justify-center gap-1 md:gap-2">
                                                <a href="{{ route('admin.questions.view', $question->id) }}"
                                                    class="p-1.5 md:p-2 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 transition"
                                                    title="View">
                                                    <i class="bi bi-eye text-sm md:text-base"></i>
                                                </a>
                                                <a href="{{ route('admin.questions.edit', $question->id) }}"
                                                    class="p-1.5 md:p-2 rounded-lg bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 border border-yellow-500/30 transition"
                                                    title="Edit">
                                                    <i class="bi bi-pencil text-sm md:text-base"></i>
                                                </a>
                                                <button onclick="confirmDeleteQuestion({{ $question->id }})"
                                                    class="p-1.5 md:p-2 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 transition"
                                                    title="Delete">
                                                    <i class="bi bi-trash text-sm md:text-base"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <i class="bi bi-inbox text-slate-600 text-5xl md:text-6xl block mb-4"></i>
                                            <p class="text-slate-400 text-base md:text-lg mb-2">No questions found.</p>
                                            @if ($search || $filterCompetition || $filterCategory || $filterDifficulty || $filterStatus)
                                                <p class="text-slate-500 text-sm">Try adjusting your filter criteria.
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="block md:hidden divide-y divide-slate-700/50">
                        @forelse($questions as $question)
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <span
                                            class="text-xs font-semibold text-slate-500 mb-1 block">#{{ $question->id }}</span>
                                        <div class="text-white font-medium text-base line-clamp-2 mb-2">
                                            {{ $question->question_text }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($question->validation_status === 'approved')
                                            <span
                                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-green-500/20 text-green-400 border border-green-500/30">APP</span>
                                        @elseif($question->validation_status === 'pending')
                                            <span
                                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">PEN</span>
                                        @else
                                            <span
                                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">REJ</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="bg-slate-900/50 p-2 rounded-lg border border-slate-700/50">
                                        <span class="text-slate-500 text-xs block mb-1">Competition</span>
                                        <span
                                            class="text-slate-300 truncate block">{{ Str::limit($question->competition->title ?? 'N/A', 20) }}</span>
                                    </div>
                                    <div class="bg-slate-900/50 p-2 rounded-lg border border-slate-700/50">
                                        <span class="text-slate-500 text-xs block mb-1">Category</span>
                                        <span
                                            class="text-slate-300 truncate block">{{ $question->category->name ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <div class="flex items-center gap-2">
                                        @if ($question->difficulty_level === 'easy')
                                            <span
                                                class="px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">Easy</span>
                                        @elseif($question->difficulty_level === 'medium')
                                            <span
                                                class="px-2 py-0.5 rounded text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Medium</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">Hard</span>
                                        @endif
                                        <span class="text-slate-400 text-xs flex items-center gap-1">
                                            <i class="bi bi-star-fill text-yellow-500/50"></i>
                                            {{ $question->point_weight }} pts
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.questions.view', $question->id) }}"
                                            class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 border border-blue-500/20 transition">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question->id) }}"
                                            class="p-2 rounded-lg bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 border border-yellow-500/20 transition">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmDeleteQuestion({{ $question->id }})"
                                            class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 transition">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i class="bi bi-inbox text-slate-600 text-4xl block mb-3"></i>
                                <p class="text-slate-400 text-sm">No questions found.</p>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- Mobile Pagination -->
                @if ($questions->hasPages())
                    <div
                        class="md:hidden mb-6 bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-4">
                        <div class="flex flex-col gap-4">
                            <!-- Results Info -->
                            <div class="text-sm text-slate-400 text-center">
                                Showing {{ $questions->firstItem() }} to {{ $questions->lastItem() }} of
                                {{ $questions->total() }} results
                            </div>

                            <!-- Pagination Controls -->
                            <div class="flex items-center justify-center gap-2">
                                {{-- Previous Button --}}
                                @if ($questions->onFirstPage())
                                    <span
                                        class="px-4 py-2 text-sm text-slate-600 bg-slate-800 border border-slate-700 rounded-lg cursor-not-allowed">
                                        «
                                    </span>
                                @else
                                    <button wire:click="previousPage"
                                        class="px-4 py-2 text-sm text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 hover:text-white transition">
                                        «
                                    </button>
                                @endif

                                {{-- Page Info --}}
                                <span
                                    class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 border border-indigo-500 rounded-lg">
                                    {{ $questions->currentPage() }} / {{ $questions->lastPage() }}
                                </span>

                                {{-- Next Button --}}
                                @if ($questions->hasMorePages())
                                    <button wire:click="nextPage"
                                        class="px-4 py-2 text-sm text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 hover:text-white transition">
                                        »
                                    </button>
                                @else
                                    <span
                                        class="px-4 py-2 text-sm text-slate-600 bg-slate-800 border border-slate-700 rounded-lg cursor-not-allowed">
                                        »
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Desktop Pagination -->
                @if ($questions->hasPages())
                    <div class="hidden md:block">
                        <div class="px-6 py-4 border-t border-slate-700">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <!-- Results Info -->
                                <div class="text-sm text-slate-400">
                                    Showing {{ $questions->firstItem() }} to {{ $questions->lastItem() }} of
                                    {{ $questions->total() }} results
                                </div>

                                <!-- Pagination Links -->
                                <div class="flex items-center gap-1">
                                    {{-- Previous Button --}}
                                    @if ($questions->onFirstPage())
                                        <span
                                            class="px-3 py-2 text-sm text-slate-600 bg-slate-800 border border-slate-700 rounded-lg cursor-not-allowed">
                                            « Previous
                                        </span>
                                    @else
                                        <button wire:click="previousPage"
                                            class="px-3 py-2 text-sm text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 hover:text-white transition">
                                            « Previous
                                        </button>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($questions->getUrlRange(1, $questions->lastPage()) as $page => $url)
                                        @if ($page == $questions->currentPage())
                                            <span
                                                class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 border border-indigo-500 rounded-lg">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})"
                                                class="px-3 py-2 text-sm text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 hover:text-white transition">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    @if ($questions->hasMorePages())
                                        <button wire:click="nextPage"
                                            class="px-3 py-2 text-sm text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 hover:text-white transition">
                                            Next »
                                        </button>
                                    @else
                                        <span
                                            class="px-3 py-2 text-sm text-slate-600 bg-slate-800 border border-slate-700 rounded-lg cursor-not-allowed">
                                            Next »
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteQuestion(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pertanyaan ini akan dihapus secara permanen beserta semua jawaban!",
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

        window.addEventListener('question-deleted', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pertanyaan berhasil dihapus.',
                icon: 'success',
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

        /* Pagination light theme */
        body.light-theme .bg-slate-800 {
            background: white !important;
        }

        body.light-theme .text-slate-600 {
            color: #94a3b8 !important;
        }

        body.light-theme .hover\:bg-slate-700:hover {
            background-color: #f1f5f9 !important;
        }
    </style>
</div>
