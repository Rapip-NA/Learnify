<?php

namespace App\Livewire\Features\Admin\Competitions;

use App\Models\Competition;
use Livewire\Component;

class CompetitionEdit extends Component
{
    public Competition $competition;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $status;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:draft,active,inactive'
    ];

    public function mount(Competition $competition)
    {
        if (auth()->user()->role === 'qualifier' && $competition->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->competition = $competition;
        $this->title = $competition->title;
        $this->description = $competition->description;
        $this->start_date = $competition->start_date->format('Y-m-d\TH:i');
        $this->end_date = $competition->end_date->format('Y-m-d\TH:i');
        $this->status = $competition->status;
    }

    public function update()
    {
        if (auth()->user()->role === 'qualifier' && $this->competition->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->validate();

        $this->competition->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ]);

        return redirect()->route('admin.competitions.index')->with('competition-updated', true);
    }

    public function render()
    {
        return view('livewire.features.admin.competitions.competition-edit');
    }
}
