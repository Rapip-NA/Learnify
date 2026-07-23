<?php

namespace App\Livewire\Features\Admin\Question;

use App\Models\Question;
use App\Models\Competition;
use App\Models\Category;
use App\Models\Answer;
use Livewire\Component;

class QuestionEdit extends Component
{
    public $questionId;
    public $competition_id;
    public $category_id;
    public $question_text;
    public $difficulty_level;
    public $point_weight;
    public $validation_status;

    // For answers
    public $answers = [];
    public $deletedAnswers = [];

    public function mount($id)
    {
        $this->questionId = $id;
        $question = Question::with(['answers', 'competition'])->findOrFail($id);

        if (auth()->user()->role === 'qualifier' && $question->competition->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->competition_id = $question->competition_id;
        $this->category_id = $question->category_id;
        $this->question_text = $question->question_text;
        $this->difficulty_level = $question->difficulty_level;
        $this->point_weight = $question->point_weight;
        $this->validation_status = $question->validation_status;

        // Load existing answers
        foreach ($question->answers as $answer) {
            $this->answers[] = [
                'id' => $answer->id,
                'answer_text' => $answer->answer_text,
                'is_correct' => $answer->is_correct,
            ];
        }

        // If no answers, add one empty
        if (empty($this->answers)) {
            $this->addAnswer();
        }
    }

    public function addAnswer()
    {
        $this->answers[] = [
            'id' => null,
            'answer_text' => '',
            'is_correct' => false,
        ];
    }

    public function removeAnswer($index)
    {
        if (isset($this->answers[$index]['id'])) {
            $this->deletedAnswers[] = $this->answers[$index]['id'];
        }
        unset($this->answers[$index]);
        $this->answers = array_values($this->answers);
    }

    public function setCorrectAnswer($index)
    {
        foreach ($this->answers as $key => $answer) {
            $this->answers[$key]['is_correct'] = ($key === $index);
        }
    }

    protected function rules()
    {
        return [
            'competition_id' => 'required|exists:competitions,id',
            'category_id' => 'required|exists:categories,id',
            'question_text' => 'required|string|min:10',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'point_weight' => 'required|integer|min:1|max:1000',
            'validation_status' => 'required|in:pending,approved,rejected',
            'answers' => 'required|array|min:2',
            'answers.*.answer_text' => 'required|string|min:1',
            'answers.*.is_correct' => 'boolean',
        ];
    }

    protected $messages = [
        'answers.min' => 'You must provide at least 2 answers.',
        'answers.*.answer_text.required' => 'All answer fields must be filled.',
    ];

    public function update()
    {
        $question = Question::findOrFail($this->questionId);
        if (auth()->user()->role === 'qualifier') {
            if ($question->competition->created_by !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
            $newComp = Competition::find($this->competition_id);
            if ($newComp && $newComp->created_by !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        $this->validate();

        // Check if at least one answer is marked as correct
        $hasCorrectAnswer = collect($this->answers)->contains('is_correct', true);

        if (!$hasCorrectAnswer) {
            $this->addError('answers', 'You must mark at least one answer as correct.');
            return;
        }

        $question->update([
            'competition_id' => $this->competition_id,
            'category_id' => $this->category_id,
            'question_text' => $this->question_text,
            'difficulty_level' => $this->difficulty_level,
            'point_weight' => $this->point_weight,
            'validation_status' => $this->validation_status,
        ]);

        // Delete removed answers
        if (!empty($this->deletedAnswers)) {
            Answer::whereIn('id', $this->deletedAnswers)->delete();
        }

        // Update or create answers
        foreach ($this->answers as $answer) {
            if ($answer['id']) {
                Answer::find($answer['id'])->update([
                    'answer_text' => $answer['answer_text'],
                    'is_correct' => $answer['is_correct'] ?? false,
                ]);
            } else {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answer['answer_text'],
                    'is_correct' => $answer['is_correct'] ?? false,
                ]);
            }
        }

        $this->dispatch('question-updated');
    }

    public function render()
    {
        $competitions = Competition::select('id', 'title')
            ->when(auth()->user()->role === 'qualifier', function ($query) {
                $query->where('created_by', auth()->id());
            })
            ->get();
        $categories = Category::select('id', 'name')->get();

        return view('livewire.features.admin.question.question-edit', [
            'competitions' => $competitions,
            'categories' => $categories,
        ]);
    }
}
