<?php

namespace App\Livewire;

use App\Models\Business;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class BusinessDetail extends Component
{
    use WithPagination;

    public $business;
    public $image;
    public $isFeatured;
    public $ratingFilter = '';
    public $sortReviews = 'latest';

    public function mount(Business $business)
    {
        $this->business = $business;
        $this->image = $business->image;
        $this->isFeatured = $business->is_featured;
    }

    public function toggleFeatured()
    {
        if (!Auth::user()->isAdmin()) {
            return;
        }

        $this->business->update([
            'is_featured' => !$this->isFeatured
        ]);

        $this->isFeatured = !$this->isFeatured;
    }

    #[On('reviewAdded')]
    public function refreshBusiness()
    {
        // Refresh the business to get updated reviews and avg_rating
        $this->business = Business::with(['reviews.user', 'category'])
            ->findOrFail($this->business->id);
    }

    public function updatingRatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSortReviews()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = $this->business->reviews()
            ->with('user')
            ->when($this->ratingFilter, function ($query) {
                $query->where('rating', '>=', $this->ratingFilter);
            });

        // Apply sorting
        switch ($this->sortReviews) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'highest':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc');
                break;
            default:
                $query->latest();
        }

        $reviews = $query->paginate(10);

        return view('livewire.business-detail', [
            'business' => $this->business->load(['reviews.user', 'category']),
            'isAdmin' => Auth::user()?->isAdmin() ?? false,
            'reviews' => $reviews,
        ]);
    }
}
