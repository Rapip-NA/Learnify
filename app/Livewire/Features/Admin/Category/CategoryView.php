<?php

namespace App\Livewire\Features\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class CategoryView extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        if (auth()->user()->role === 'qualifier' && $category->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->category = $category;
    }
    public function render()
    {
        return view('livewire.features.admin.category.category-view');
    }
}
