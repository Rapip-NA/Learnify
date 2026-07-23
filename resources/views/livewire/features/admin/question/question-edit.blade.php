<div>
    <div>
        <div>
            <div>
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1
                                class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2">
                                Edit Question
                            </h1>
                            <p class="text-slate-400">Update the details and answers for this question.</p>
                        </div>
                        <a href="{{ route('admin.questions.index') }}"
                            class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-slate-800 border border-slate-700 text-white font-semibold rounded-xl hover:bg-slate-700 transition-all w-full md:w-auto">
                            <i class="bi bi-arrow-left"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Form Card -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="px-4 py-4 md:px-6 md:py-4 border-b border-slate-700">
                        <h3 class="text-xl font-bold text-white">Update Question Details</h3>
                    </div>

                    <div class="p-4 md:p-6">
                        <form wire:submit.prevent="update" class="space-y-6">
                            <!-- Competition & Category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Competition <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="competition_id"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('competition_id') border-red-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="">Select Competition</option>
                                        @foreach ($competitions as $competition)
                                            <option value="{{ $competition->id }}">{{ $competition->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('competition_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Category <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="category_id"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('category_id') border-red-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Question Text -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">
                                    Question Text <span class="text-red-400">*</span>
                                </label>
                                <textarea wire:model="question_text" rows="4"
                                    class="w-full px-4 py-3 bg-slate-900 border @error('question_text') border-red-500 @else border-slate-700 @enderror rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="Enter your question here..."></textarea>
                                @error('question_text')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Difficulty, Points, Status, Type -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Question Type <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model.live="question_type"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('question_type') border-red-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="essay">Essay</option>
                                    </select>
                                    @error('question_type')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Difficulty <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="difficulty_level"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('difficulty_level') border-red-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                    @error('difficulty_level')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Point Weight <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" wire:model="point_weight" min="1" max="1000"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('point_weight') border-red-500 @else border-slate-700 @enderror rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                        placeholder="100">
                                    @error('point_weight')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                                        Status <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="validation_status"
                                        class="w-full px-4 py-3 bg-slate-900 border @error('validation_status') border-red-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                    @error('validation_status')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Answers Section (only for multiple choice) -->
                            @if($question_type === 'multiple_choice')
                            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 md:p-6">
                                <div
                                    class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                                    <label class="text-lg font-semibold text-white">
                                        Answers <span class="text-red-400">*</span>
                                        <span class="text-sm text-slate-400">(at least 2 required)</span>
                                    </label>
                                    <button type="button" wire:click="addAnswer"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/20 text-green-400 border border-green-500/30 font-semibold rounded-lg hover:bg-green-500/30 transition">
                                        <i class="bi bi-plus-lg"></i>
                                        Add Answer
                                    </button>
                                </div>

                                @error('answers')
                                    <div
                                        class="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @foreach ($answers as $index => $answer)
                                    <div
                                        class="flex flex-col md:flex-row gap-3 mb-3 items-start md:items-center p-4 rounded-xl bg-slate-900 border border-slate-700">
                                        <div class="flex items-center gap-2">
                                            <input type="radio" wire:click="setCorrectAnswer({{ $index }})"
                                                name="correct_answer" {{ $answer['is_correct'] ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-500 focus:ring-indigo-500 cursor-pointer">
                                            <label class="text-xs text-slate-400">Correct?</label>
                                        </div>
                                        <div class="flex-grow">
                                            <input type="text" wire:model="answers.{{ $index }}.answer_text"
                                                placeholder="Answer {{ $index + 1 }}"
                                                class="w-full px-3 py-2 bg-slate-800 border @error('answers.' . $index . '.answer_text') border-red-500 @else border-slate-700 @enderror rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                            @error('answers.' . $index . '.answer_text')
                                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @if (count($answers) > 2)
                                            <button type="button" wire:click="removeAnswer({{ $index }})"
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-red-500/20 text-red-400 border border-red-500/30 font-semibold rounded-lg hover:bg-red-500/30 transition text-sm"
                                                title="Remove Answer">
                                                <i class="bi bi-x-lg"></i>
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                @endforeach

                                <p class="text-sm text-slate-400 mt-4">
                                    <strong class="text-white">Tip:</strong> Use the radio button next to the field to
                                    mark the correct answer.
                                </p>
                            </div>
                            @else
                            {{-- Essay info box --}}
                            <div class="bg-purple-500/10 border border-purple-500/30 rounded-xl p-5 flex items-start gap-4">
                                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">✏️</div>
                                <div>
                                    <h4 class="text-purple-300 font-bold text-lg mb-1">Soal Tipe Essay</h4>
                                    <p class="text-slate-400 text-sm">Soal ini berjenis essay — peserta akan menjawab dengan teks bebas. Jawaban tidak diperiksa otomatis, dan harus divalidasi secara manual oleh qualifier pembuat soal.</p>
                                </div>
                            </div>
                            @endif

                            <!-- Buttons -->
                            <div class="flex flex-col md:flex-row justify-end gap-4 pt-6 border-t border-slate-700">
                                <a href="{{ route('admin.questions.index') }}"
                                    class="inline-flex justify-center items-center px-6 py-3 bg-slate-700 text-white font-semibold rounded-xl hover:bg-slate-600 transition-all w-full md:w-auto">
                                    Cancel
                                </a>
                                <button type="button" onclick="confirmUpdate()"
                                    class="inline-flex items-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all w-full md:w-auto justify-center">
                                    <i class="bi bi-check-circle"></i>
                                    Update Question
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Apakah Anda yakin ingin memperbarui pertanyaan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#e2e8f0',
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('update');
                }
            });
        }

        window.addEventListener('question-updated', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pertanyaan berhasil diperbarui.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0',
            }).then(() => {
                window.location.href = "{{ route('admin.questions.index') }}";
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

        body.light-theme .bg-slate-900,
        body.light-theme .bg-slate-800 {
            background: #f8fafc !important;
        }

        body.light-theme input,
        body.light-theme select,
        body.light-theme textarea {
            background: white !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        body.light-theme .bg-slate-800\/50 {
            background: #f8fafc !important;
        }
    </style>
</div>
