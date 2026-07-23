<?php

namespace App\Livewire\Features\Peserta\Competitions;

use Livewire\Component;
use App\Models\Competition;
use App\Models\CompetitionParticipant;
use App\Models\ParticipantAnswer;

class CompetitionResult extends Component
{
    public $competition;
    public $participant;
    public $answers;
    public $correctAnswers;
    public $wrongAnswers;
    public $hasPendingEssay = false;
    public $pendingEssayCount = 0;

    public function mount(Competition $competition)
    {
        $this->competition = $competition;

        $this->participant = CompetitionParticipant::where('user_id', auth()->id())
            ->where('competition_id', $competition->id)
            ->firstOrFail();

        $this->answers = ParticipantAnswer::where('competition_participant_id', $this->participant->id)
            ->with(['question.category', 'question.answers', 'answer', 'verifier'])
            ->get();

        $this->correctAnswers = $this->answers->where('is_correct', true)->count();
        $this->wrongAnswers = $this->answers->where('is_correct', false)->where('grading_status', 'graded')->count();

        // Detect pending essay answers
        $pendingEssays = $this->answers->filter(
            fn($a) => $a->question?->question_type === 'essay' && $a->grading_status === 'pending'
        );
        $this->hasPendingEssay = $pendingEssays->isNotEmpty();
        $this->pendingEssayCount = $pendingEssays->count();
    }

    /**
     * Get performance data for visualization chart
     * Returns cumulative score progression over time/questions
     */
    public function getPerformanceData()
    {
        // Get all answers ordered by answered_at timestamp
        $orderedAnswers = ParticipantAnswer::where('competition_participant_id', $this->participant->id)
            ->with('question')
            ->orderBy('answered_at', 'asc')
            ->get();

        $cumulativeScore = 0;
        $dataPerQuestion = [];
        $dataPerTime = [];
        
        $startTime = $this->participant->started_at;

        foreach ($orderedAnswers as $index => $answer) {
            // Calculate score for this answer
            $scoreEarned = 0;
            
            // Only add score if answer is correct and approved (or pending)
            if ($answer->is_correct && in_array($answer->validation_status, ['approved', 'pending'])) {
                $scoreEarned = $answer->question->point_weight ?? 0;
            }
            
            $cumulativeScore += $scoreEarned;
            
            // Data for "Per Question" mode
            $dataPerQuestion[] = [
                'x' => $index + 1, // Question number (1, 2, 3, ...)
                'y' => (float) $cumulativeScore,
                'questionText' => $answer->question->question_text ?? '',
                'scoreEarned' => (float) $scoreEarned
            ];
            
            // Data for "Per Time" mode
            if ($answer->answered_at && $startTime) {
                $timeElapsed = $answer->answered_at->diffInSeconds($startTime);
                $dataPerTime[] = [
                    'x' => round($timeElapsed / 60, 2), // Convert to minutes
                    'y' => (float) $cumulativeScore,
                    'questionText' => $answer->question->question_text ?? '',
                    'scoreEarned' => (float) $scoreEarned
                ];
            }
        }

        return [
            'perQuestion' => $dataPerQuestion,
            'perTime' => $dataPerTime,
            'finalScore' => (float) $cumulativeScore,
            'totalQuestions' => count($orderedAnswers)
        ];
    }

    public function render()
    {
        $performanceData = $this->getPerformanceData();

        return view('livewire.features.peserta.competitions.competition-result', [
            'performanceData'   => $performanceData,
            'hasPendingEssay'   => $this->hasPendingEssay,
            'pendingEssayCount' => $this->pendingEssayCount,
        ]);
    }
}
