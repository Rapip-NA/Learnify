<?php

namespace App\Livewire\Features\Admin\Question;

use App\Models\Question;
use Livewire\Component;

class QuestionView extends Component
{
    public $question;
    public $deleteId = null;

    public function mount($id)
    {
        $this->question = Question::with([
            'competition',
            'category',
            'verifier',
            'answers'
        ])->findOrFail($id);

        if (auth()->user()->role === 'qualifier' && $this->question->competition->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function confirmDelete()
    {
        $this->deleteId = $this->question->id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $question = Question::find($this->deleteId);
            
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
                
                session()->flash('message', 'Question deleted successfully.');
                return redirect()->route('admin.questions.index');
            }
        }
    }

    public function render()
    {
        return view('livewire.features.admin.question.question-view');
    }
}
