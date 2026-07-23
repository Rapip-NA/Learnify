<?php

namespace App\Livewire\Features\Admin\Question;

use App\Models\Question;
use App\Models\Competition;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $filterCompetition = '';
    public $filterCategory = '';
    public $filterDifficulty = '';
    public $filterStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCompetition' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterDifficulty' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCompetition()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterDifficulty()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }



    public function delete($id)
    {
        $question = Question::find($id);
        
        if ($question) {
            if (auth()->user()->role === 'qualifier' && $question->competition->created_by !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
            // Delete related answers first
            $question->answers()->delete();
            
            // Delete related participant answers
            $question->participantAnswers()->delete();
            
            // Finally delete the question
            $question->delete();
            
            $this->dispatch('question-deleted');
        }
    }

    public function render()
    {
        $questions = Question::with(['competition', 'category', 'verifier'])
            ->when(auth()->user()->role === 'qualifier', function ($query) {
                $query->whereHas('competition', function ($q) {
                    $q->where('created_by', auth()->id());
                });
            })
            ->when($this->search, function ($query) {
                $query->where('question_text', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCompetition, function ($query) {
                $query->where('competition_id', $this->filterCompetition);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterDifficulty, function ($query) {
                $query->where('difficulty_level', $this->filterDifficulty);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('validation_status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        $competitions = Competition::select('id', 'title')
            ->when(auth()->user()->role === 'qualifier', function ($query) {
                $query->where('created_by', auth()->id());
            })
            ->get();
        $categories = Category::select('id', 'name')->get();

        return view('livewire.features.admin.question.question-index', [
            'questions' => $questions,
            'competitions' => $competitions,
            'categories' => $categories,
        ]);
    }
}
