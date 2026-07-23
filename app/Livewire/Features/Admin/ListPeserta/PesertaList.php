<?php

namespace App\Livewire\Features\Admin\ListPeserta;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PesertaList extends Component
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

    public function deletePeserta($id)
    {
        $user = User::find($id);

        if ($user && $user->role === 'peserta') {
            $user->delete();
            $this->dispatch('peserta-deleted');
        }
    }

    public function render()
    {
        $peserta = User::where('role', 'peserta')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.features.admin.list-peserta.peserta-list', [
            'peserta' => $peserta
        ]);
    }
}
