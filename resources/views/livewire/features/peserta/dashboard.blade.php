<div>
    <div>
        <div>
            <div>
                <!-- Page Header -->
                <div class="mb-8">
                    <h1
                        class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-400 to-pink-400 bg-clip-text mb-2 flex items-center gap-2">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard Peserta
                    </h1>
                    <p class="text-slate-400">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Kompetisi -->
                    <div
                        class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 rounded-2xl p-6 hover:-translate-y-1 transition-transform">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-blue-500/30 flex items-center justify-center">
                                <i class="bi bi-trophy-fill text-blue-400 text-2xl"></i>
                            </div>
                            <div class="flex-grow">
                                <p class="text-slate-400 text-xs mb-1">Total Kompetisi</p>
                                <h3 class="text-2xl font-bold text-white">{{ $stats['totalParticipations'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Kompetisi Selesai -->
                    <div
                        class="bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 rounded-2xl p-6 hover:-translate-y-1 transition-transform">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-green-500/30 flex items-center justify-center">
                                <i class="bi bi-check-circle-fill text-green-400 text-2xl"></i>
                            </div>
                            <div class="flex-grow">
                                <p class="text-slate-400 text-xs mb-1">Selesai</p>
                                <h3 class="text-2xl font-bold text-white">{{ $stats['completedCompetitions'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Skor -->
                    <div
                        class="bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 rounded-2xl p-6 hover:-translate-y-1 transition-transform">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-purple-500/30 flex items-center justify-center">
                                <i class="bi bi-star-fill text-purple-400 text-2xl"></i>
                            </div>
                            <div class="flex-grow">
                                <p class="text-slate-400 text-xs mb-1">Total Skor</p>
                                <h3 class="text-2xl font-bold text-white">{{ number_format($stats['totalScore'], 0) }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Rata-rata Skor -->
                    <div
                        class="bg-gradient-to-br from-red-500/20 to-red-600/20 border border-red-500/30 rounded-2xl p-6 hover:-translate-y-1 transition-transform">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-red-500/30 flex items-center justify-center">
                                <i class="bi bi-graph-up text-red-400 text-2xl"></i>
                            </div>
                            <div class="flex-grow">
                                <p class="text-slate-400 text-xs mb-1">Rata-rata</p>
                                <h3 class="text-2xl font-bold text-white">{{ number_format($stats['avgScore'], 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Qualifier Application Alert/Card -->
                @if (session()->has('qualifier_message'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <i class="bi bi-check-circle text-green-400 text-xl"></i>
                        <span class="text-green-400 font-semibold">{{ session('qualifier_message') }}</span>
                    </div>
                @endif

                @if (Auth::user()->qualifier_application_status === 'pending')
                    <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/30 rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                                <i class="bi bi-hourglass-split text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Pengajuan Menjadi Qualifier Sedang Diproses</h4>
                                <p class="text-slate-400 text-sm">Terima kasih atas pengajuan Anda. Admin sedang meninjau data Anda untuk menjadi Qualifier.</p>
                            </div>
                        </div>
                    </div>
                @elseif (Auth::user()->qualifier_application_status === 'rejected')
                    <div class="bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/30 rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400">
                                <i class="bi bi-exclamation-octagon text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Pengajuan Qualifier Belum Disetujui</h4>
                                <p class="text-slate-400 text-sm">Sayangnya pengajuan Anda sebelumnya ditolak. Anda dapat mencoba mengajukan diri kembali.</p>
                            </div>
                        </div>
                        <button wire:click="applyForQualifier" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-red-500/50">
                            Ajukan Kembali
                        </button>
                    </div>
                @elseif (!Auth::user()->qualifier_application_status)
                    <div class="bg-gradient-to-br from-indigo-500/10 to-purple-600/10 border border-indigo-500/20 rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                                <i class="bi bi-shield-lock text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-lg">Tertarik Menjadi Qualifier?</h4>
                                <p class="text-slate-400 text-sm">Dapatkan akses untuk membuat kompetisi, kategori, serta memverifikasi jawaban peserta lainnya.</p>
                            </div>
                        </div>
                        <button wire:click="applyForQualifier" class="px-6 py-3 gradient-primary text-white font-bold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all flex items-center gap-2">
                            <i class="bi bi-person-plus-fill"></i>
                            Ajukan Diri Sekarang
                        </button>
                    </div>
                @endif

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Performance Bar Chart -->
                    <div
                        class="lg:col-span-2 bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-slate-900/50 border-b border-slate-700">
                            <h4 class="text-xl font-bold text-white flex items-center gap-2">
                                <i class="bi bi-bar-chart-fill text-indigo-400"></i>
                                Performa Kompetisi
                            </h4>
                        </div>
                        <div class="p-6">
                            @if (count($chartData['competitions']) > 0)
                                <div id="performanceBarChart"></div>
                            @else
                                <div class="text-center py-12">
                                    <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                                    <p class="text-slate-400">Belum ada kompetisi yang diselesaikan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Completion Donut Chart -->
                    <div
                        class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-slate-900/50 border-b border-slate-700">
                            <h4 class="text-xl font-bold text-white flex items-center gap-2">
                                <i class="bi bi-pie-chart-fill text-indigo-400"></i>
                                Status Kompetisi
                            </h4>
                        </div>
                        <div class="p-6">
                            @if ($stats['totalParticipations'] > 0)
                                <div id="completionDonutChart"></div>
                                <div class="text-center mt-4">
                                    <h5 class="text-3xl font-bold text-white mb-1">{{ $completionData['percentage'] }}%
                                    </h5>
                                    <p class="text-slate-400 text-sm">Tingkat Penyelesaian</p>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="bi bi-inbox text-slate-600 text-6xl block mb-4"></i>
                                    <p class="text-slate-400">Belum ada kompetisi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 bg-slate-900/50 border-b border-slate-700">
                        <h4 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="bi bi-clock-history text-indigo-400"></i>
                            Aktivitas Terbaru
                        </h4>
                    </div>
                    <div class="p-6">
                        @if ($recentActivities->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="border-b border-slate-700">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                Kompetisi</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                Skor</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                Tanggal Mulai</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-700/50">
                                        @foreach ($recentActivities as $activity)
                                            <tr class="hover:bg-slate-800/50 transition">
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <i class="bi bi-trophy text-yellow-400"></i>
                                                        <strong
                                                            class="text-white">{{ $activity->competition->title }}</strong>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    @if ($activity->finished_at)
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold">
                                                            <i class="bi bi-check-circle"></i>
                                                            Selesai
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded-full text-xs font-semibold">
                                                            <i class="bi bi-hourglass-split"></i>
                                                            Dalam Progress
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4">
                                                    <strong
                                                        class="text-indigo-400 text-lg">{{ $activity->total_score }}</strong>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <small
                                                        class="text-slate-400">{{ $activity->started_at?->format('d M Y, H:i') ?? '-' }}</small>
                                                </td>
                                                <td class="px-4 py-4">
                                                    @if ($activity->finished_at)
                                                        <a href="{{ route('peserta.competitions.result', $activity->competition_id) }}"
                                                            class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 rounded-lg hover:bg-indigo-500/30 transition text-sm font-medium">
                                                            <i class="bi bi-eye"></i>
                                                            Lihat Hasil
                                                        </a>
                                                    @else
                                                        <a href="{{ route('peserta.competitions.quiz', $activity->competition_id) }}"
                                                            class="inline-flex items-center gap-1 px-4 py-2 bg-green-500/20 text-green-400 border border-green-500/30 rounded-lg hover:bg-green-500/30 transition text-sm font-medium">
                                                            <i class="bi bi-play-fill"></i>
                                                            Lanjutkan
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="bi bi-inbox text-slate-600 text-8xl block mb-4"></i>
                                <p class="text-slate-400 mb-6">Belum ada aktivitas</p>
                                <a href="{{ route('peserta.competitions.list') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all">
                                    <i class="bi bi-plus-circle"></i>
                                    Mulai Kompetisi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ApexCharts Library --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if dark theme is active
            const isDarkTheme = !document.body.classList.contains('light-theme');

            // Theme colors
            const textColor = isDarkTheme ? '#e2e8f0' : '#0f172a';
            const gridColor = isDarkTheme ? '#334155' : '#e2e8f0';
            const tooltipBg = isDarkTheme ? '#1e293b' : '#ffffff';

            // Performance Bar Chart
            @if (count($chartData['competitions']) > 0)
                const performanceOptions = {
                    series: [{
                        name: 'Skor',
                        data: @json($chartData['scores'])
                    }],
                    chart: {
                        type: 'bar',
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
                        }
                    },
                    theme: {
                        mode: isDarkTheme ? 'dark' : 'light'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            dataLabels: {
                                position: 'top',
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: [textColor]
                        }
                    },
                    xaxis: {
                        categories: @json($chartData['competitions']),
                        labels: {
                            rotate: -45,
                            rotateAlways: true,
                            style: {
                                fontSize: '11px',
                                colors: textColor
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Skor',
                            style: {
                                color: textColor
                            }
                        },
                        labels: {
                            style: {
                                colors: textColor
                            }
                        }
                    },
                    grid: {
                        borderColor: gridColor
                    },
                    colors: ['#6366f1'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.3,
                            opacityFrom: 0.9,
                            opacityTo: 0.7,
                        }
                    },
                    tooltip: {
                        theme: isDarkTheme ? 'dark' : 'light'
                    }
                };

                const performanceChart = new ApexCharts(document.querySelector("#performanceBarChart"),
                    performanceOptions);
                performanceChart.render();
            @endif

            // Completion Donut Chart
            @if ($stats['totalParticipations'] > 0)
                const donutOptions = {
                    series: [{{ $completionData['completed'] }}, {{ $completionData['inProgress'] }}],
                    chart: {
                        type: 'donut',
                        height: 280,
                        background: 'transparent'
                    },
                    theme: {
                        mode: isDarkTheme ? 'dark' : 'light'
                    },
                    labels: ['Selesai', 'Dalam Progress'],
                    colors: ['#22c55e', '#eab308'],
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: textColor
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        color: textColor,
                                        formatter: function(w) {
                                            return {{ $stats['totalParticipations'] }}
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.config.series[opts.seriesIndex]
                        },
                        style: {
                            colors: ['#fff']
                        }
                    },
                    tooltip: {
                        theme: isDarkTheme ? 'dark' : 'light'
                    }
                };

                const donutChart = new ApexCharts(document.querySelector("#completionDonutChart"), donutOptions);
                donutChart.render();
            @endif
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

        body.light-theme .bg-slate-800\/50 {
            background: #f8fafc !important;
        }

        body.light-theme .bi-inbox {
            color: #cbd5e1 !important;
        }
    </style>
</div>
