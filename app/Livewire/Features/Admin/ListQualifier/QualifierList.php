<?php

namespace App\Livewire\Features\Admin\ListQualifier;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class QualifierList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteQualifier($id)
    {
        $user = User::find($id);

        if ($user && $user->role === 'qualifier') {
            $user->delete();
            $this->dispatch('qualifier-deleted');
        }
    }

    public function render()
    {
        $qualifiers = User::where('role', 'qualifier')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount('verifiedQuestions', 'verifiedParticipantAnswers')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.features.admin.list-qualifier.qualifier-list', [
            'qualifiers' => $qualifiers
        ])->layout('components.layouts.app');
    }
}
