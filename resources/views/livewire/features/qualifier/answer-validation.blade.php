<div class="space-y-8" x-data="gradingModal()">
    <!-- Page Header -->
    <div class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-4xl md:text-5xl font-black text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text">
                    Validasi Jawaban Essay
                </h1>
                <p class="text-lg text-slate-400 mt-2">Nilai jawaban essay peserta dari kompetisi yang Anda buat</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('qualifier.dashboard') }}" class="text-slate-400 hover:text-white transition">Dashboard</a>
                <span class="text-slate-600">/</span>
                <span class="text-white font-medium">Validasi Essay</span>
            </nav>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-gradient-to-br from-green-800 to-green-900 border border-green-700 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="bi bi-check-circle text-green-400 text-xl"></i>
            </div>
            <p class="text-green-100">{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-gradient-to-br from-red-800 to-red-900 border border-red-700 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="bi bi-x-circle text-red-400 text-xl"></i>
            </div>
            <p class="text-red-100">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Pending -->
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 opacity-0 group-hover:opacity-10 rounded-full blur-3xl transition-all duration-500"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Menunggu Validasi</p>
                    <h3 class="text-4xl font-black text-transparent bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text">{{ $statistics['pending'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-yellow-500 bg-opacity-20 rounded-xl flex items-center justify-center text-2xl">⏳</div>
            </div>
        </div>

        <!-- Approved -->
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500 opacity-0 group-hover:opacity-10 rounded-full blur-3xl transition-all duration-500"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Disetujui</p>
                    <h3 class="text-4xl font-black text-transparent bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text">{{ $statistics['approved'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-green-500 bg-opacity-20 rounded-xl flex items-center justify-center text-2xl">✅</div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6 group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500 opacity-0 group-hover:opacity-10 rounded-full blur-3xl transition-all duration-500"></div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Ditolak</p>
                    <h3 class="text-4xl font-black text-transparent bg-gradient-to-r from-red-400 to-pink-400 bg-clip-text">{{ $statistics['rejected'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-red-500 bg-opacity-20 rounded-xl flex items-center justify-center text-2xl">❌</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <span class="text-2xl">🔍</span> Filter
        </h3>
        <div class="grid md:grid-cols-12 gap-4">
            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div class="md:col-span-4">
                <label class="block text-sm font-semibold text-slate-300 mb-2">Kompetisi</label>
                <select wire:model.live="competitionFilter"
                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">Semua Kompetisi Saya</option>
                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}">{{ $competition->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-5">
                <label class="block text-sm font-semibold text-slate-300 mb-2">Cari Peserta</label>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Cari nama peserta...">
            </div>
        </div>
    </div>

    {{-- Essay Answer Cards --}}
    <div class="space-y-4">
        @if ($answers->count() > 0)
            @foreach ($answers as $answer)
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300">
                    <!-- Card Header -->
                    <div class="p-5 border-b border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($answer->competitionParticipant->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-white">{{ $answer->competitionParticipant->user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $answer->answered_at?->format('d M Y H:i') ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-full text-xs font-semibold border border-cyan-500/30">
                                {{ $answer->competitionParticipant->competition->title }}
                            </span>
                            <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-semibold border border-purple-500/30">
                                ✏️ Essay
                            </span>
                            @if ($answer->grading_status === 'pending')
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs font-semibold border border-yellow-500/30">⏳ Pending</span>
                            @elseif ($answer->validation_status === 'approved')
                                <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-semibold border border-green-500/30">✅ Disetujui</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-300 rounded-full text-xs font-semibold border border-red-500/30">❌ Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 space-y-4">
                        <!-- Question -->
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Soal</p>
                            <p class="text-white font-medium leading-relaxed bg-slate-900/50 rounded-xl p-4 border border-slate-700">
                                {{ $answer->question->question_text }}
                            </p>
                            <div class="flex gap-3 mt-2">
                                <span class="text-xs text-slate-500">Bobot: <span class="text-indigo-400 font-semibold">{{ $answer->question->point_weight }} poin</span></span>
                            </div>
                        </div>

                        <!-- Essay Answer -->
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jawaban Peserta</p>
                            <div class="bg-slate-700/40 rounded-xl p-4 border border-slate-600 text-slate-200 leading-relaxed whitespace-pre-wrap">
                                {{ $answer->essay_answer_text ?: '(tidak ada jawaban)' }}
                            </div>
                        </div>

                        <!-- Grading Result (if already graded) -->
                        @if ($answer->grading_status === 'graded')
                            <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700 flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <p class="text-xs text-slate-400 mb-1">Skor Diberikan</p>
                                    <p class="text-2xl font-bold {{ $answer->validation_status === 'approved' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $answer->score_earned }} / {{ $answer->question->point_weight }}
                                    </p>
                                </div>
                                @if ($answer->grading_notes)
                                    <div class="flex-2">
                                        <p class="text-xs text-slate-400 mb-1">Catatan Qualifier</p>
                                        <p class="text-slate-300 text-sm italic">{{ $answer->grading_notes }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Dinilai oleh</p>
                                    <p class="text-slate-300 text-sm font-medium">{{ $answer->verifier?->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $answer->graded_at?->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Card Actions -->
                    @if ($answer->grading_status === 'pending')
                        <div class="px-5 pb-5 flex items-center gap-3">
                            <button
                                wire:click="openApproveModal({{ $answer->id }})"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500/20 hover:bg-green-500/30 text-green-300 border border-green-500/30 rounded-xl font-semibold transition-all text-sm">
                                <i class="bi bi-check-circle"></i> Setujui & Beri Skor
                            </button>
                            <button
                                wire:click="openRejectModal({{ $answer->id }})"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 rounded-xl font-semibold transition-all text-sm">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-6">
                {{ $answers->links() }}
            </div>
        @else
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-12 text-center">
                <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-inbox text-slate-400" style="font-size: 2.5rem;"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Tidak Ada Jawaban</h3>
                <p class="text-slate-400">Tidak ada jawaban essay yang ditemukan untuk filter yang dipilih.</p>
            </div>
        @endif
    </div>

    {{-- Grading Modal --}}
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @open-grading-modal.window="open = true"
        @close-grading-modal.window="open = false">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>

        <!-- Modal -->
        <div class="relative z-10 w-full max-w-xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden shadow-2xl"
             x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-700 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <span wire:ignore>
                        @if($gradingAction === 'approve') ✅ Setujui Jawaban @else ❌ Tolak Jawaban @endif
                    </span>
                </h3>
                <button @click="open = false" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white transition rounded-lg hover:bg-slate-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <!-- Question preview -->
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Soal</p>
                    <p class="text-slate-300 text-sm bg-slate-900/50 rounded-lg p-3 border border-slate-700 leading-relaxed">{{ $gradingQuestionText }}</p>
                </div>

                <!-- Essay answer preview -->
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jawaban Peserta</p>
                    <div class="text-slate-200 text-sm bg-slate-700/40 rounded-lg p-3 border border-slate-600 max-h-40 overflow-y-auto whitespace-pre-wrap leading-relaxed">{{ $gradingEssayText ?: '(tidak ada jawaban)' }}</div>
                </div>

                @if($gradingAction === 'approve')
                    <!-- Score input -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">
                            Skor yang Diberikan
                            <span class="text-slate-400 font-normal">(maks. {{ $gradingMaxScore }} poin)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" wire:model.live="gradingScore"
                                min="0" max="{{ $gradingMaxScore }}"
                                class="flex-1 px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white text-lg font-bold focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                            <span class="text-slate-400 text-sm font-medium">/ {{ $gradingMaxScore }}</span>
                        </div>
                        <!-- Score slider -->
                        <input type="range" wire:model.live="gradingScore"
                            min="0" max="{{ $gradingMaxScore }}"
                            class="w-full mt-3 accent-green-500">
                        <div class="flex justify-between text-xs text-slate-500 mt-1">
                            <span>0 (Tidak ada skor)</span>
                            <span>{{ $gradingMaxScore }} (Penuh)</span>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                        Catatan untuk Peserta
                        @if($gradingAction === 'reject') <span class="text-red-400">*</span> @else <span class="text-slate-400 font-normal">(opsional)</span> @endif
                    </label>
                    <textarea wire:model="gradingNotes" rows="3"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition resize-none"
                        placeholder="{{ $gradingAction === 'reject' ? 'Jelaskan alasan penolakan...' : 'Catatan feedback untuk peserta (opsional)...' }}"></textarea>
                    @error('gradingNotes')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-700 flex justify-end gap-3">
                <button @click="open = false"
                    class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition">
                    Batal
                </button>
                <button wire:click="submitGrading"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="{{ $gradingAction === 'approve' ? 'bg-gradient-to-r from-green-500 to-emerald-600 hover:shadow-green-500/30' : 'bg-gradient-to-r from-red-500 to-red-600 hover:shadow-red-500/30' }} px-6 py-2.5 text-white font-bold rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                    <span wire:loading.remove wire:target="submitGrading">
                        @if($gradingAction === 'approve') <i class="bi bi-check-circle"></i> Konfirmasi Setujui @else <i class="bi bi-x-circle"></i> Konfirmasi Tolak @endif
                    </span>
                    <span wire:loading wire:target="submitGrading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function gradingModal() {
        return {
            open: false,
        }
    }
</script>
@endpush
