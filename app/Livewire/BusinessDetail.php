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
    public $showImageModal = false;
    public $currentImageIndex = 0;
    public $reviewImages = [];

    public function mount(Business $business)
    {
        $this->business = $business;
        $this->image = $business->image;
        $this->isFeatured = $business->is_featured;
        $this->loadReviewImages();
    }

    public function loadReviewImages()
    {
        // Get all reviews with images, regardless of pagination
        $this->reviewImages = $this->business->reviews()
            ->whereNotNull('image')
            ->pluck('image')
            ->map(function ($image) {
                return asset('storage/' . $image);
            })
            ->toArray();
    }

    public function showImage($reviewId)
    {
        // Find the review with the image
        $review = $this->business->reviews()
            ->where('id', $reviewId)
            ->whereNotNull('image')
            ->first();
            
        if ($review) {
            $imageUrl = asset('storage/' . $review->image);
            $this->currentImageIndex = array_search($imageUrl, $this->reviewImages);
            $this->showImageModal = true;
        }
    }

    public function nextImage()
    {
        if ($this->currentImageIndex < count($this->reviewImages) - 1) {
            $this->currentImageIndex++;
        }
    }

    public function previousImage()
    {
        if ($this->currentImageIndex > 0) {
            $this->currentImageIndex--;
        }
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
