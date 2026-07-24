<?php

namespace App\Livewire\Features\Peserta\Competitions;

use Livewire\Component;
use App\Models\Competition;
use App\Models\CompetitionParticipant;
use App\Models\Question;
use App\Models\ParticipantAnswer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\ScoringService;
use App\Services\BadgeService;

class CompetitionQuiz extends Component
{
    public $competition;
    public $participant;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $selectedAnswer = null;
    public $essayAnswerText = ''; // For essay-type questions
    public $answers = [];
    public $questionStartedAt; // Track when current question was started
    public $isFinished = false;
    public $remainingSeconds = 300;
    public $timeExpired = false;

    public function mount(Competition $competition)
    {
        $this->competition = $competition->load(['questions.answers', 'questions.category']);

        // Validasi: Cek apakah kompetisi aktif
        if ($this->competition->status !== 'active') {
            session()->flash('error', 'Kompetisi ini tidak dapat diakses. Status: ' . ucfirst($this->competition->status));
            return redirect()->route('peserta.competitions.list');
        }

        // Validasi: Cek apakah kompetisi sudah berakhir
        if ($this->competition->end_date < now()) {
            session()->flash('error', 'Kompetisi ini sudah berakhir pada ' . $this->competition->end_date->format('d M Y H:i'));
            return redirect()->route('peserta.competitions.list');
        }

        // Get or create participant
        $this->participant = CompetitionParticipant::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'competition_id' => $this->competition->id
            ],
            [
                'started_at' => now(),
                'total_score' => 0,
                'progress_percentage' => 0
            ]
        );

        // Check if already finished
        if ($this->participant->finished_at) {
            $this->isFinished = true;
            return;
        }

        // Calculate remaining time
        $this->calculateRemainingTime();

        // Auto finish if time expired
        if ($this->remainingSeconds <= 0) {
            $this->timeExpired = true;
            $this->autoFinishCompetition();
            return;
        }

        // Get approved questions
        $this->questions = $this->competition->questions()
            ->where('validation_status', 'approved')
            ->with(['answers', 'category'])
            ->get();

        // Check if competition has questions
        if ($this->questions->count() === 0) {
            session()->flash('error', 'Kompetisi ini sedang dalam proses persiapan. Belum ada soal yang tersedia.');
            return redirect()->route('peserta.competitions.list');
        }

        // Load existing answers
        $this->loadExistingAnswers();

        $this->questionStartedAt = now();
    }

    public function calculateRemainingTime()
    {
        $startedAt = Carbon::parse($this->participant->started_at);
        $durationSeconds = $this->competition->duration_seconds ?? 320;
        $endTime = $startedAt->copy()->addSeconds($durationSeconds);

        $this->remainingSeconds = max(0, now()->diffInSeconds($endTime, false));
    }

    public function checkTimer()
    {
        $this->calculateRemainingTime();

        if ($this->remainingSeconds <= 0 && !$this->isFinished) {
            $this->timeExpired = true;
            $this->autoFinishCompetition();
        }
    }

    public function loadExistingAnswers()
    {
        $existingAnswers = ParticipantAnswer::where('competition_participant_id', $this->participant->id)
            ->get(['question_id', 'answer_id', 'essay_answer_text']);

        foreach ($this->questions as $index => $question) {
            $answerObj = $existingAnswers->firstWhere('question_id', $question->id);
            if ($answerObj) {
                if ($question->isEssay()) {
                    if (!empty($answerObj->essay_answer_text)) {
                        $this->answers[$index] = -1; // Marker for answered essay
                        // Load saved text into component property if it's the current question
                        if ($index === $this->currentQuestionIndex) {
                            $this->essayAnswerText = $answerObj->essay_answer_text;
                        }
                    }
                } else {
                    if ($answerObj->answer_id !== null) {
                        $this->answers[$index] = $answerObj->answer_id;
                    }
                }
            }
        }

        // Set current question to first unanswered
        foreach ($this->questions as $index => $question) {
            if (!isset($this->answers[$index])) {
                $this->currentQuestionIndex = $index;
                break;
            }
        }

        // Initialize state for the starting question
        $this->loadQuestionData();
    }

    public function getCurrentQuestion()
    {
        return $this->questions[$this->currentQuestionIndex] ?? null;
    }

    public function selectAnswer($answerId)
    {
        if ($this->timeExpired || $this->isFinished) {
            return;
        }
        $this->selectedAnswer = $answerId;
    }

    public function submitAnswer()
    {
        if ($this->timeExpired || $this->isFinished) {
            return;
        }

        $question = $this->getCurrentQuestion();

        // Handle essay questions
        if ($question->isEssay()) {
            if (empty(trim($this->essayAnswerText))) {
                session()->flash('error', 'Tulis jawaban essay terlebih dahulu!');
                return;
            }

            $timeSpent = now()->diffInSeconds($this->questionStartedAt);

            // Save essay answer with pending grading status
            ParticipantAnswer::updateOrCreate(
                [
                    'competition_participant_id' => $this->participant->id,
                    'question_id' => $question->id,
                ],
                [
                    'essay_answer_text' => $this->essayAnswerText,
                    'answer_id' => null, // No predefined answer for essays
                    'is_correct' => false, // Will be set during grading
                    'time_spent' => $timeSpent,
                    'answered_at' => now(),
                    'score_earned' => 0, // Will be set during grading
                    'grading_status' => 'pending',
                    'validation_status' => 'pending'
                ]
            );

            // Store marker in local array (use -1 to indicate essay submission)
            $this->answers[$this->currentQuestionIndex] = -1;

            // Update progress
            $this->updateProgress();

            // Reset for next question
            $this->essayAnswerText = '';
            $this->questionStartedAt = now();

            session()->flash('success', 'Jawaban essay berhasil disimpan!');
            return;
        }

        // Handle multiple choice questions (existing logic)
        if (!$this->selectedAnswer) {
            session()->flash('error', 'Pilih jawaban terlebih dahulu!');
            return;
        }

        $answer = $question->answers()->find($this->selectedAnswer);

        if (!$answer) {
            session()->flash('error', 'Jawaban tidak valid!');
            return;
        }

        $timeSpent = now()->diffInSeconds($this->questionStartedAt);

        // Calculate score using ScoringService
        $scoringService = new ScoringService();
        $scoreEarned = $scoringService->calculateAnswerScore(
            $answer,
            $question,
            $this->competition,
            $timeSpent
        );

        // Save answer with score
        ParticipantAnswer::updateOrCreate(
            [
                'competition_participant_id' => $this->participant->id,
                'question_id' => $question->id,
            ],
            [
                'answer_id' => $this->selectedAnswer,
                'is_correct' => $answer->is_correct,
                'time_spent' => $timeSpent,
                'answered_at' => now(),
                'score_earned' => $scoreEarned,
                'grading_status' => 'not_applicable',
                'validation_status' => 'pending'
            ]
        );

        // Store in local array
        $this->answers[$this->currentQuestionIndex] = $this->selectedAnswer;

        // Update progress
        $this->updateProgress();

        // Reset for next question
        $this->selectedAnswer = null;
        $this->questionStartedAt = now();

        session()->flash('success', 'Jawaban berhasil disimpan!');
    }

    public function nextQuestion()
    {
        // Auto-save current answer if selected (multiple choice)
        if ($this->selectedAnswer) {
            $this->submitAnswer();
        }

        // Auto-save essay answer if filled
        $question = $this->getCurrentQuestion();
        if ($question && $question->isEssay() && !empty(trim($this->essayAnswerText))) {
            $this->submitAnswer();
        }

        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->loadQuestionData();
        }
    }

    public function previousQuestion()
    {
        // Auto-save current answer if selected (multiple choice)
        if ($this->selectedAnswer) {
            $this->submitAnswer();
        }

        // Auto-save essay answer if filled
        $question = $this->getCurrentQuestion();
        if ($question && $question->isEssay() && !empty(trim($this->essayAnswerText))) {
            $this->submitAnswer();
        }

        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->loadQuestionData();
        }
    }

    public function goToQuestion($index)
    {
        // Auto-save current answer if selected before navigating (multiple choice)
        if ($this->selectedAnswer && $index != $this->currentQuestionIndex) {
            $this->submitAnswer();
        }

        // Auto-save essay answer if filled
        $question = $this->getCurrentQuestion();
        if ($question && $question->isEssay() && !empty(trim($this->essayAnswerText)) && $index != $this->currentQuestionIndex) {
            $this->submitAnswer();
        }

        $this->currentQuestionIndex = $index;
        $this->loadQuestionData();
    }

    private function loadQuestionData()
    {
        $question = $this->getCurrentQuestion();
        $this->selectedAnswer = null;
        $this->essayAnswerText = '';

        $existingAnswer = ParticipantAnswer::where('competition_participant_id', $this->participant->id)
            ->where('question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            if ($question->isEssay()) {
                $this->essayAnswerText = $existingAnswer->essay_answer_text;
            } else {
                $this->selectedAnswer = $existingAnswer->answer_id;
            }
        } else {
            $this->questionStartedAt = now();
        }
    }

    public function updateProgress()
    {
        $totalQuestions = count($this->questions);
        $answeredQuestions = count($this->answers);
        
        // Prevent division by zero
        $progress = $totalQuestions > 0 ? ($answeredQuestions / $totalQuestions) * 100 : 0;

        $this->participant->update([
            'progress_percentage' => round($progress, 2)
        ]);

        $this->participant->refresh();
    }

    public function finishCompetition()
    {
        if ($this->isFinished) {
            return;
        }

        // Auto-save current answer if selected (for last question)
        if ($this->selectedAnswer) {
            $this->submitAnswer();
        }

        // Auto-save essay answer if filled (for last question)
        $question = $this->getCurrentQuestion();
        if ($question && $question->isEssay() && !empty(trim($this->essayAnswerText))) {
            $this->submitAnswer();
        }

        // Check if all questions answered
        if (count($this->answers) < count($this->questions)) {
            session()->flash('error', 'Jawab semua soal terlebih dahulu!');
            return;
        }

        $this->processCompletition();
    }

    private function autoFinishCompetition()
    {
        if ($this->isFinished) {
            return;
        }

        $this->processCompletition();
        session()->flash('warning', 'Waktu habis! Kuis telah diselesaikan secara otomatis.');
    }

    private function processCompletition()
    {
        DB::transaction(function () {
            // Calculate total score using ScoringService
            $scoringService = new ScoringService();
            $totalScore = $scoringService->calculateTotalScore($this->participant);

            // Update participant
            $this->participant->update([
                'finished_at' => now(),
                'total_score' => $totalScore,
                'progress_percentage' => 100
            ]);

            // Update leaderboard
            \App\Models\Leaderboard::updateOrCreate(
                [
                    'competition_id' => $this->competition->id,
                    'user_id' => auth()->id()
                ],
                [
                    'score' => $totalScore,
                    'updated_at' => now()
                ]
            );

            // Recalculate ranks
            $this->updateLeaderboardRanks();

            // Check and award badges automatically
            $badgeService = new BadgeService();
            $badgeService->checkAndAwardBadges(auth()->user());
        });

        $this->isFinished = true;
        $this->participant->refresh();
    }

    private function updateLeaderboardRanks()
    {
        $leaderboards = \App\Models\Leaderboard::where('competition_id', $this->competition->id)
            ->orderBy('score', 'desc')
            ->orderBy('updated_at', 'asc')
            ->get();

        foreach ($leaderboards as $index => $leaderboard) {
            $leaderboard->update(['rank' => $index + 1]);
        }
    }

    public function render()
    {
        $currentQuestion = $this->getCurrentQuestion();

        return view('livewire.features.peserta.competitions.competition-quiz', [
            'currentQuestion' => $currentQuestion,
            'totalQuestions' => count($this->questions),
            'answeredCount' => count($this->answers)
        ]);
    }
}
