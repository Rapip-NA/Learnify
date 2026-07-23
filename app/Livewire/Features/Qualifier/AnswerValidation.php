<?php

namespace App\Livewire\Features\Qualifier;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\ParticipantAnswer;
use App\Models\CompetitionParticipant;
use App\Models\Competition;
use App\Models\Leaderboard;
use App\Services\ScoringService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswerValidation extends Component
{
    use WithPagination;

    #[Layout('components.layouts.app')]
    #[Title('Validasi Jawaban Essay')]

    public $statusFilter = 'pending';
    public $competitionFilter = '';
    public $search = '';

    // For grading modal
    public $gradingAnswerId = null;
    public $gradingScore = 0;
    public $gradingNotes = '';
    public $gradingAction = ''; // 'approve' or 'reject'
    public $gradingMaxScore = 0;
    public $gradingQuestionText = '';
    public $gradingEssayText = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCompetitionFilter()
    {
        $this->resetPage();
    }

    /**
     * Open the grading modal for approving an essay answer
     */
    public function openApproveModal($answerId)
    {
        $answer = ParticipantAnswer::with(['question', 'competitionParticipant.user'])->find($answerId);
        if (!$answer) return;

        // Security: qualifier can only grade answers from their own competitions
        $competition = $answer->competitionParticipant->competition;
        if ($competition->created_by !== Auth::id()) {
            session()->flash('error', 'Anda tidak berhak memvalidasi jawaban ini.');
            return;
        }

        $this->gradingAnswerId = $answerId;
        $this->gradingAction = 'approve';
        $this->gradingScore = $answer->question->point_weight; // default to full score
        $this->gradingMaxScore = $answer->question->point_weight;
        $this->gradingNotes = '';
        $this->gradingQuestionText = $answer->question->question_text;
        $this->gradingEssayText = $answer->essay_answer_text;
        $this->dispatch('open-grading-modal');
    }

    /**
     * Open the grading modal for rejecting an essay answer
     */
    public function openRejectModal($answerId)
    {
        $answer = ParticipantAnswer::with(['question', 'competitionParticipant.user'])->find($answerId);
        if (!$answer) return;

        $competition = $answer->competitionParticipant->competition;
        if ($competition->created_by !== Auth::id()) {
            session()->flash('error', 'Anda tidak berhak memvalidasi jawaban ini.');
            return;
        }

        $this->gradingAnswerId = $answerId;
        $this->gradingAction = 'reject';
        $this->gradingScore = 0;
        $this->gradingMaxScore = $answer->question->point_weight;
        $this->gradingNotes = '';
        $this->gradingQuestionText = $answer->question->question_text;
        $this->gradingEssayText = $answer->essay_answer_text;
        $this->dispatch('open-grading-modal');
    }

    /**
     * Submit the grading decision
     */
    public function submitGrading()
    {
        if (!$this->gradingAnswerId) return;

        $answer = ParticipantAnswer::with(['competitionParticipant.competition', 'question'])->find($this->gradingAnswerId);
        if (!$answer) return;

        // Security check
        $competition = $answer->competitionParticipant->competition;
        if ($competition->created_by !== Auth::id()) {
            session()->flash('error', 'Tidak berhak memvalidasi jawaban ini.');
            $this->closeGradingModal();
            return;
        }

        if ($this->gradingAction === 'approve') {
            $score = max(0, min((float) $this->gradingScore, (float) $this->gradingMaxScore));

            $answer->update([
                'grading_status'    => 'graded',
                'validation_status' => 'approved',
                'is_correct'        => true,
                'score_earned'      => $score,
                'grading_notes'     => $this->gradingNotes ?: null,
                'graded_at'         => now(),
                'verified_by'       => Auth::id(),
            ]);
        } else {
            $this->validate(['gradingNotes' => 'required|string|min:3'], [
                'gradingNotes.required' => 'Catatan wajib diisi saat menolak jawaban.',
                'gradingNotes.min' => 'Catatan minimal 3 karakter.',
            ]);

            $answer->update([
                'grading_status'    => 'graded',
                'validation_status' => 'rejected',
                'is_correct'        => false,
                'score_earned'      => 0,
                'grading_notes'     => $this->gradingNotes,
                'graded_at'         => now(),
                'verified_by'       => Auth::id(),
            ]);
        }

        // Recalculate participant total score and update leaderboard
        $this->recalculateAndUpdateLeaderboard($answer->competitionParticipant);

        $this->closeGradingModal();
        session()->flash('success', $this->gradingAction === 'approve'
            ? 'Jawaban essay berhasil disetujui dan skor diberikan!'
            : 'Jawaban essay ditolak.');
    }

    /**
     * Recalculate participant total score and update leaderboard
     */
    private function recalculateAndUpdateLeaderboard(CompetitionParticipant $participant): void
    {
        DB::transaction(function () use ($participant) {
            $scoringService = new ScoringService();
            $totalScore = $scoringService->calculateTotalScore($participant);

            $participant->update(['total_score' => $totalScore]);

            // Update leaderboard entry
            Leaderboard::updateOrCreate(
                [
                    'competition_id' => $participant->competition_id,
                    'user_id'        => $participant->user_id,
                ],
                [
                    'score'      => $totalScore,
                    'updated_at' => now(),
                ]
            );

            // Recalculate ranks for the competition
            $leaderboards = Leaderboard::where('competition_id', $participant->competition_id)
                ->orderBy('score', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();

            foreach ($leaderboards as $index => $lb) {
                $lb->update(['rank' => $index + 1]);
            }
        });
    }

    public function closeGradingModal()
    {
        $this->gradingAnswerId = null;
        $this->gradingScore = 0;
        $this->gradingNotes = '';
        $this->gradingAction = '';
        $this->gradingMaxScore = 0;
        $this->gradingQuestionText = '';
        $this->gradingEssayText = '';
        $this->dispatch('close-grading-modal');
    }

    public function getStatistics()
    {
        // Only count essay answers from qualifier's own competitions
        $myCompetitionIds = Competition::where('created_by', Auth::id())->pluck('id');

        $base = ParticipantAnswer::whereHas('question', fn($q) => $q->where('question_type', 'essay'))
            ->whereHas('competitionParticipant', fn($q) => $q->whereIn('competition_id', $myCompetitionIds));

        return [
            'pending'  => (clone $base)->where('grading_status', 'pending')->count(),
            'approved' => (clone $base)->where('grading_status', 'graded')->where('validation_status', 'approved')->count(),
            'rejected' => (clone $base)->where('grading_status', 'graded')->where('validation_status', 'rejected')->count(),
        ];
    }

    public function render()
    {
        $myCompetitionIds = Competition::where('created_by', Auth::id())->pluck('id');

        $answers = ParticipantAnswer::with([
                'competitionParticipant.user',
                'competitionParticipant.competition',
                'question',
                'verifier',
            ])
            // Only essay type questions
            ->whereHas('question', fn($q) => $q->where('question_type', 'essay'))
            // Only competitions created by this qualifier
            ->whereHas('competitionParticipant', fn($q) => $q->whereIn('competition_id', $myCompetitionIds))
            ->when($this->statusFilter && $this->statusFilter !== 'all', function ($query) {
                if ($this->statusFilter === 'pending') {
                    $query->where('grading_status', 'pending');
                } else {
                    $query->where('grading_status', 'graded')->where('validation_status', $this->statusFilter);
                }
            })
            ->when($this->competitionFilter, function ($query) {
                $query->whereHas('competitionParticipant', fn($q) => $q->where('competition_id', $this->competitionFilter));
            })
            ->when($this->search, function ($query) {
                $query->whereHas('competitionParticipant.user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $competitions = Competition::where('created_by', Auth::id())->orderBy('title')->get();
        $statistics = $this->getStatistics();

        return view('livewire.features.qualifier.answer-validation', [
            'answers'      => $answers,
            'competitions' => $competitions,
            'statistics'   => $statistics,
        ]);
    }
}
