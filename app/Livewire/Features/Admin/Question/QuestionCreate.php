<?php

namespace App\Livewire\Features\Admin\Question;

use App\Models\Question;
use App\Models\Competition;
use App\Models\Category;
use App\Models\Answer;
use Livewire\Component;

class QuestionCreate extends Component
{
    public $competition_id;
    public $category_id;
    public $question_text;
    public $question_type = 'multiple_choice';
    public $difficulty_level = 'easy';
    public $point_weight;
    public $validation_status = 'pending';

    // For answers
    public $answers = [];

    public function mount()
    {
        // Initialize with two empty answers for multiple choice (default)
        $this->addAnswer();
        $this->addAnswer();

        if (auth()->user()->role === 'qualifier') {
            $this->validation_status = 'approved';
        }
    }

    public function addAnswer()
    {
        $this->answers[] = [
            'answer_text' => '',
            'is_correct' => false,
        ];
    }

    public function removeAnswer($index)
    {
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
        $rules = [
            'competition_id' => 'required|exists:competitions,id',
            'category_id' => 'required|exists:categories,id',
            'question_text' => 'required|string|min:10',
            'question_type' => 'required|in:multiple_choice,essay',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'point_weight' => 'required|integer|min:1|max:1000',
            'validation_status' => 'required|in:pending,approved,rejected',
        ];

        // Only require answers for multiple choice questions
        if ($this->question_type === 'multiple_choice') {
            $rules['answers'] = 'required|array|min:2';
            $rules['answers.*.answer_text'] = 'required|string|min:1';
            $rules['answers.*.is_correct'] = 'boolean';
        }

        return $rules;
    }

    protected $messages = [
        'answers.min' => 'You must provide at least 2 answers.',
        'answers.*.answer_text.required' => 'All answer fields must be filled.',
    ];

    public function save()
    {
        if (auth()->user()->role === 'qualifier') {
            $comp = Competition::find($this->competition_id);
            if ($comp && $comp->created_by !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        $this->validate();

        // Check if at least one answer is marked as correct (only for multiple choice)
        if ($this->question_type === 'multiple_choice') {
            $hasCorrectAnswer = collect($this->answers)->contains('is_correct', true);

            if (!$hasCorrectAnswer) {
                $this->addError('answers', 'You must mark at least one answer as correct.');
                return;
            }
        }

        $question = Question::create([
            'competition_id' => $this->competition_id,
            'category_id' => $this->category_id,
            'question_text' => $this->question_text,
            'question_type' => $this->question_type,
            'difficulty_level' => $this->difficulty_level,
            'point_weight' => $this->point_weight,
            'validation_status' => $this->validation_status,
        ]);

        // Save answers (only for multiple choice questions)
        if ($this->question_type === 'multiple_choice') {
            foreach ($this->answers as $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answer['answer_text'],
                    'is_correct' => $answer['is_correct'] ?? false,
                ]);
            }
        }

        session()->flash('message', 'Question created successfully.');

        if (auth()->user()->role === 'qualifier') {
            return redirect()->route('qualifier.questions.index');
        }
        return redirect()->route('admin.questions.index');
    }

    public function render()
    {
        $competitions = Competition::select('id', 'title')
            ->when(auth()->user()->role === 'qualifier', function ($query) {
                $query->where('created_by', auth()->id());
            })
            ->get();
        $categories = Category::select('id', 'name')->get();

        return view('livewire.features.admin.question.question-create', [
            'competitions' => $competitions,
            'categories' => $categories,
        ]);
    }
}
