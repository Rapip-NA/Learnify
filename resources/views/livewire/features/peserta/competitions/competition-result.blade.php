<div>
    <div>
        <div>
            <!-- Page Header -->
            <div class="mb-8">
                <h1
                    class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2">
                    Hasil Kompetisi
                </h1>
            </div>

            <!-- HEADER STATS -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">{{ $competition->title }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 border border-indigo-500/30 rounded-xl p-6 text-center">
                            <p class="text-slate-400 text-sm mb-2">Total Skor</p>
                            <h2 class="text-5xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text">
                                {{ $participant->total_score }}
                            </h2>
                            @if($hasPendingEssay)
                                <p class="text-xs text-yellow-400 mt-2">*Belum termasuk {{ $pendingEssayCount }} soal essay</p>
                            @endif
                        </div>

                        <div class="bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 rounded-xl p-6 text-center">
                            <p class="text-slate-400 text-sm mb-2">Jawaban Benar</p>
                            <h2 class="text-5xl font-bold text-green-400">{{ $correctAnswers }}</h2>
                        </div>

                        <div class="bg-gradient-to-br from-red-500/20 to-red-600/20 border border-red-500/30 rounded-xl p-6 text-center">
                            <p class="text-slate-400 text-sm mb-2">Jawaban Salah</p>
                            <h2 class="text-5xl font-bold text-red-400">{{ $wrongAnswers }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PENDING ESSAY BANNER --}}
            @if($hasPendingEssay)
            <div class="bg-gradient-to-br from-yellow-900/50 to-orange-900/50 border border-yellow-600/50 rounded-2xl p-5 mb-6 flex items-start gap-4">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">⏳</div>
                <div>
                    <h4 class="text-yellow-300 font-bold text-lg mb-1">Hasil Sedang Divalidasi</h4>
                    <p class="text-yellow-200/80 text-sm">Kompetisi ini memiliki <strong>{{ $pendingEssayCount }} soal essay</strong> yang belum dinilai oleh qualifier. Skor akhir Anda akan diperbarui setelah semua jawaban essay selesai divalidasi.</p>
                </div>
            </div>
            @endif

            <!-- VISUALISASI PERFORMA INDIVIDU -->
            <div
                class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-4 bg-slate-900/50 border-b border-slate-700">
                    <h4 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="bi bi-graph-up text-indigo-400"></i>
                        Visualisasi Performa Individu
                    </h4>
                </div>
                <div class="p-6">
                    <p class="text-slate-400 mb-4">
                        Grafik berikut menunjukkan perkembangan skor Anda dari awal hingga akhir kuis.
                    </p>

                    <!-- Toggle Mode -->
                    <div class="flex gap-2 mb-6">
                        <button type="button" id="togglePerQuestion"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl flex items-center gap-2"
                            onclick="switchChartMode('perQuestion')">
                            <i class="bi bi-list-ol"></i>
                            Per Soal
                        </button>
                        <button type="button" id="togglePerTime"
                            class="px-6 py-3 bg-slate-700 text-slate-300 font-semibold rounded-xl flex items-center gap-2 hover:bg-slate-600 transition"
                            onclick="switchChartMode('perTime')">
                            <i class="bi bi-clock"></i>
                            Per Waktu
                        </button>
                    </div>

                    <!-- Chart Container -->
                    <div id="performanceChart"></div>
                </div>
            </div>

            <!-- REVIEW JAWABAN -->
            @foreach ($answers as $index => $participantAnswer)
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Badge Info -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-2 flex-wrap">
                                <span class="px-3 py-1 bg-slate-600 text-slate-200 rounded-full text-sm font-semibold">
                                    Soal {{ $index + 1 }}
                                </span>
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full text-sm font-semibold">
                                    {{ $participantAnswer->question->category->name }}
                                </span>
                                @if($participantAnswer->question->question_type === 'essay')
                                    <span class="px-3 py-1 bg-purple-500/20 text-purple-400 border border-purple-500/30 rounded-full text-sm font-semibold">
                                        ✏️ Essay
                                    </span>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            @if($participantAnswer->question->question_type === 'essay')
                                @if($participantAnswer->grading_status === 'pending')
                                    <span class="px-4 py-2 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded-full text-sm font-semibold flex items-center gap-1">
                                        ⏳ Menunggu Validasi
                                    </span>
                                @elseif($participantAnswer->validation_status === 'approved')
                                    <span class="px-4 py-2 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-sm font-semibold flex items-center gap-1">
                                        <i class="bi bi-check-circle"></i> Disetujui
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-sm font-semibold flex items-center gap-1">
                                        <i class="bi bi-x-circle"></i> Ditolak
                                    </span>
                                @endif
                            @else
                                @if ($participantAnswer->is_correct)
                                    <span class="px-4 py-2 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-sm font-semibold flex items-center gap-1">
                                        <i class="bi bi-check-circle"></i> Benar
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-sm font-semibold flex items-center gap-1">
                                        <i class="bi bi-x-circle"></i> Salah
                                    </span>
                                @endif
                            @endif
                        </div>

                        <!-- SOAL -->
                        <h5 class="text-xl font-bold text-white mb-6">{{ $participantAnswer->question->question_text }}</h5>

                        @if($participantAnswer->question->question_type === 'essay')
                            {{-- ESSAY ANSWER DISPLAY --}}
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jawaban Anda</p>
                                    <div class="bg-slate-700/40 rounded-xl p-4 border border-slate-600 text-slate-200 leading-relaxed whitespace-pre-wrap">
                                        {{ $participantAnswer->essay_answer_text ?: '(tidak ada jawaban)' }}
                                    </div>
                                </div>

                                @if($participantAnswer->grading_status === 'graded')
                                    <div class="bg-slate-900/40 rounded-xl p-4 border border-slate-700 flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-xs text-slate-400 mb-1">Skor Diterima</p>
                                            <p class="text-2xl font-bold {{ $participantAnswer->validation_status === 'approved' ? 'text-green-400' : 'text-red-400' }}">
                                                {{ $participantAnswer->score_earned }} / {{ $participantAnswer->question->point_weight }}
                                            </p>
                                        </div>
                                        @if($participantAnswer->grading_notes)
                                            <div class="flex-1">
                                                <p class="text-xs text-slate-400 mb-1">Catatan dari Qualifier</p>
                                                <p class="text-slate-300 text-sm italic leading-relaxed">{{ $participantAnswer->grading_notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- MULTIPLE CHOICE ANSWER DISPLAY --}}
                            @foreach ($participantAnswer->question->answers as $answer)
                                <div class="p-4 rounded-xl border mb-3
                                    @if ($answer->is_correct) border-green-500 bg-green-500/10
                                    @elseif($answer->id == $participantAnswer->answer_id) border-red-500 bg-red-500/10
                                    @else border-slate-600 bg-slate-800/30 @endif">
                                    <div class="flex items-start gap-3">
                                        @if ($answer->is_correct)
                                            <i class="bi bi-check-circle text-green-400 text-2xl mt-1"></i>
                                        @elseif($answer->id == $participantAnswer->answer_id)
                                            <i class="bi bi-x-circle text-red-400 text-2xl mt-1"></i>
                                        @else
                                            <div style="width: 28px;"></div>
                                        @endif
                                        <div class="flex-grow text-slate-200">{{ $answer->answer_text }}</div>
                                        @if ($answer->is_correct)
                                            <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold">Jawaban Benar</span>
                                        @elseif($answer->id == $participantAnswer->answer_id)
                                            <span class="px-3 py-1 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-xs font-semibold">Jawaban Anda</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Detail -->
                        <div class="mt-4 text-slate-400 text-sm">
                            Bobot: {{ $participantAnswer->question->point_weight }} poin |
                            Waktu: {{ $participantAnswer->time_spent }} detik
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- BACK BUTTON -->
            <div class="text-center mt-8">
                <a href="{{ route('peserta.competitions.list') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 gradient-primary text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all text-lg">
                    <i class="bi bi-arrow-left-circle"></i>
                    Kembali ke Daftar Kompetisi
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const performanceData = @json($performanceData);
        let currentMode = 'perQuestion';
        let chart = null;
        const isDarkTheme = !document.body.classList.contains('light-theme');
        const textColor = isDarkTheme ? '#e2e8f0' : '#0f172a';
        const gridColor = isDarkTheme ? '#334155' : '#e2e8f0';

        document.addEventListener('DOMContentLoaded', function() {
            renderChart('perQuestion');
        });

        function switchChartMode(mode) {
            currentMode = mode;
            const perQuestionBtn = document.getElementById('togglePerQuestion');
            const perTimeBtn = document.getElementById('togglePerTime');
            if (mode === 'perQuestion') {
                perQuestionBtn.className =
                    'px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl flex items-center gap-2';
                perTimeBtn.className =
                    'px-6 py-3 bg-slate-700 text-slate-300 font-semibold rounded-xl flex items-center gap-2 hover:bg-slate-600 transition';
            } else {
                perQuestionBtn.className =
                    'px-6 py-3 bg-slate-700 text-slate-300 font-semibold rounded-xl flex items-center gap-2 hover:bg-slate-600 transition';
                perTimeBtn.className =
                    'px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl flex items-center gap-2';
            }
            renderChart(mode);
        }

        function renderChart(mode) {
            const data = mode === 'perQuestion' ? performanceData.perQuestion : performanceData.perTime;
            if (chart) chart.destroy();
            const options = {
                series: [{
                    name: 'Skor Kumulatif',
                    data: data
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    background: 'transparent',
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                theme: {
                    mode: isDarkTheme ? 'dark' : 'light'
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    hover: {
                        size: 7
                    }
                },
                colors: ['#6366f1'],
                xaxis: {
                    title: {
                        text: mode === 'perQuestion' ? 'Nomor Soal' : 'Waktu (menit)',
                        style: {
                            fontSize: '14px',
                            fontWeight: 600,
                            color: textColor
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return mode === 'perQuestion' ? 'Soal ' + Math.round(value) : value.toFixed(1) + ' min';
                        },
                        style: {
                            colors: textColor
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Skor Kumulatif',
                        style: {
                            fontSize: '14px',
                            fontWeight: 600,
                            color: textColor
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        },
                        style: {
                            colors: textColor
                        }
                    }
                },
                tooltip: {
                    theme: isDarkTheme ? 'dark' : 'light',
                    custom: function({
                        dataPointIndex
                    }) {
                        const point = data[dataPointIndex];
                        const questionPreview = point.questionText.length > 50 ? point.questionText.substring(0,
                            50) + '...' : point.questionText;
                        return '<div class="p-3" style="background: ' + (isDarkTheme ? '#1e293b' : 'white') +
                            '; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"><div style="font-weight: 600; margin-bottom: 8px; color: #6366f1;">' +
                            (mode === 'perQuestion' ? 'Soal ' + point.x : 'Waktu: ' + point.x + ' menit') +
                            '</div><div style="font-size: 12px; color: #64748b; margin-bottom: 8px;">' +
                            questionPreview + '</div><div style="font-size: 13px; color: ' + textColor +
                            ';"><strong>Skor didapat:</strong> <span style="color: #22c55e;">+' + point
                            .scoreEarned +
                            '</span><br/><strong>Total skor:</strong> <span style="color: #6366f1;">' + point.y +
                            '</span></div></div>';
                    }
                },
                grid: {
                    borderColor: gridColor,
                    strokeDashArray: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.3,
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                }
            };
            chart = new ApexCharts(document.querySelector("#performanceChart"), options);
            chart.render();
        }
    </script>
@endpush

@push('styles')
    <style>
        body.light-theme .bg-gradient-to-br {
            background: white !important;
            border-color: #e2e8f0 !important;
        }

        body.light-theme .text-white {
            color: #0f172a !important;
        }

        body.light-theme .text-slate-200,
        body.light-theme .text-slate-300,
        body.light-theme .text-slate-400 {
            color: #64748b !important;
        }

        body.light-theme .border-slate-600,
        body.light-theme .border-slate-700 {
            border-color: #e2e8f0 !important;
        }

        body.light-theme .bg-slate-600,
        body.light-theme .bg-slate-700,
        body.light-theme .bg-slate-800 {
            background: #f1f5f9 !important;
        }
    </style>
@endpush
