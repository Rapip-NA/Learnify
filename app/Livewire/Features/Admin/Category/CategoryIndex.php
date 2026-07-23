<?php

namespace App\Livewire\Features\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function delete($id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                if (auth()->user()->role === 'qualifier' && $category->created_by !== auth()->id()) {
                    abort(403, 'Unauthorized action.');
                }
                $categoryName = $category->name;
                $category->delete();

                $this->dispatch('category-deleted', ['name' => $categoryName]);
                
                // Reset to first page if current page is empty after deletion
                $this->resetPage();
            }
        } catch (\Exception $e) {
            $this->dispatch('category-delete-failed', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.features.admin.category.category-index', [
            'categories' => $categories
        ]);
    }
}
