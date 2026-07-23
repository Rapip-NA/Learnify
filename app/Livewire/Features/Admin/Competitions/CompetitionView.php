<?php

namespace App\Livewire\Features\Admin\Competitions;

use App\Models\Competition;
use Livewire\Component;

class CompetitionView extends Component
{
    public Competition $competition;

    public function mount(Competition $competition)
    {
        if (auth()->user()->role === 'qualifier' && $competition->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->competition = $competition;
    }

    public function render()
    {
        return view('livewire.features.admin.competitions.competition-view');
    }
}
