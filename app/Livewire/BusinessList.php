<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = Business::with(['category', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        $businesses = $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('livewire.business-list', [
            'businesses' => $businesses,
            'categories' => $categories,
        ]);
    }
}
