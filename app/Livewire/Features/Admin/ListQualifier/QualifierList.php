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
    public $activeTab = 'qualifiers';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'activeTab' => ['except' => 'qualifiers'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
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

    public function approveApplication($id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'peserta' && $user->qualifier_application_status === 'pending') {
            $user->update([
                'role' => 'qualifier',
                'qualifier_application_status' => 'approved'
            ]);
            $this->dispatch('qualifier-approved');
        }
    }

    public function rejectApplication($id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'peserta' && $user->qualifier_application_status === 'pending') {
            $user->update([
                'qualifier_application_status' => 'rejected'
            ]);
            $this->dispatch('qualifier-rejected');
        }
    }

    public function render()
    {
        $pendingCount = User::where('role', 'peserta')
            ->where('qualifier_application_status', 'pending')
            ->count();

        if ($this->activeTab === 'applications') {
            $qualifiers = User::where('role', 'peserta')
                ->where('qualifier_application_status', 'pending')
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
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
        }

        return view('livewire.features.admin.list-qualifier.qualifier-list', [
            'qualifiers' => $qualifiers,
            'pendingCount' => $pendingCount
        ])->layout('components.layouts.app');
    }
}
