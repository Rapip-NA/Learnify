<?php

namespace App\Livewire\Features\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $name = '';
    public $description = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'Category name is required.',
        'name.max' => 'Category name cannot exceed 255 characters.',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Category created successfully.');

        return redirect()->route('admin.categories.index');
    }
    public function render()
    {
        return view('livewire.features.admin.category.category-create');
    }
}
