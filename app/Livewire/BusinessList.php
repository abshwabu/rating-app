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
    public $sortBy = 'reviews_avg_rating';
    public $sortDirection = 'desc';
    public $featuredBusinesses;

    public function mount()
    {
        $this->featuredBusinesses = Business::with(['category', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_featured', true)
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
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
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('state', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // Handle sorting
        switch ($this->sortBy) {
            case 'reviews_avg_rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'reviews_count':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('reviews_avg_rating', 'desc');
        }

        $businesses = $query->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('livewire.business-list', [
            'businesses' => $businesses,
            'categories' => $categories,
        ]);
    }
}
