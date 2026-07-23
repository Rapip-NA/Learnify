<?php

namespace App\Livewire\Features\Admin\Badge;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Badge;
use Livewire\WithPagination;

class BadgeIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Layout('components.layouts.app')]
    #[Title('Badge Management')]

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteBadge($badgeId)
    {
        $badge = Badge::find($badgeId);
        
        if ($badge) {
            $badge->delete();
            $this->dispatch('badge-deleted');
        }
    }

    public function render()
    {
        $badges = Badge::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.features.admin.badge.badge-index', [
            'badges' => $badges,
        ]);
    }
}
