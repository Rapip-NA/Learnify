<?php

namespace App\Livewire\Features\Peserta;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\CompetitionParticipant;

class Dashboard extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Peserta Dashboard')]

    public function applyForQualifier()
    {
        $user = auth()->user();
        if ($user->role === 'peserta' && (!$user->qualifier_application_status || $user->qualifier_application_status === 'rejected')) {
            $user->update(['qualifier_application_status' => 'pending']);
            session()->flash('qualifier_message', 'Pengajuan menjadi qualifier berhasil dikirim!');
        }
    }

    public function getDashboardData()
    {
        $userId = auth()->id();
        
        // Statistics
        $totalParticipations = CompetitionParticipant::where('user_id', $userId)->count();
        $completedCompetitions = CompetitionParticipant::where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->count();
        $totalScore = CompetitionParticipant::where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->sum('total_score');
        $avgScore = $completedCompetitions > 0 ? round($totalScore / $completedCompetitions, 2) : 0;
        
        // Competition performance data for chart (last 10 completed)
        $competitionPerformance = CompetitionParticipant::where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->with('competition')
            ->orderBy('finished_at', 'desc')
            ->take(10)
            ->get()
            ->reverse()
            ->values();
        
        // Chart data preparation
        $chartData = [
            'competitions' => $competitionPerformance->pluck('competition.title')->toArray(),
            'scores' => $competitionPerformance->pluck('total_score')->toArray(),
        ];
        
        // Recent activities (last 5)
        $recentActivities = CompetitionParticipant::where('user_id', $userId)
            ->with('competition')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Completion data for donut chart
        $inProgress = $totalParticipations - $completedCompetitions;
        $completionPercentage = $totalParticipations > 0 
            ? round(($completedCompetitions / $totalParticipations) * 100, 1) 
            : 0;
        
        return [
            'stats' => [
                'totalParticipations' => $totalParticipations,
                'completedCompetitions' => $completedCompetitions,
                'totalScore' => $totalScore,
                'avgScore' => $avgScore,
            ],
            'chartData' => $chartData,
            'recentActivities' => $recentActivities,
            'completionData' => [
                'completed' => $completedCompetitions,
                'inProgress' => $inProgress,
                'percentage' => $completionPercentage,
            ],
        ];
    }

    public function render()
    {
        $dashboardData = $this->getDashboardData();
        
        return view('livewire.features.peserta.dashboard', $dashboardData);
    }
}
