<?php

namespace App\Livewire;

use App\Models\Business;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class BusinessDetail extends Component
{
    use WithPagination, WithFileUploads;

    public $business;
    public $image;
    public $isFeatured;
    public $ratingFilter = '';
    public $sortReviews = 'latest';
    public $showImageModal = false;
    public $currentImageIndex = 0;
    public $reviewImages = [];
    public $currentReviewId = null;
    public $editingReview = null;
    public $editComment = '';
    public $editRating = 0;
    public $editImage = null;

    public function mount(Business $business)
    {
        $this->business = $business;
        $this->image = $business->image;
        $this->isFeatured = $business->is_featured;
    }

    public function showImage($reviewId)
    {
        // Get images only from this specific review
        $review = $this->business->reviews()
            ->where('id', $reviewId)
            ->whereNotNull('image')
            ->first();
            
        if ($review) {
            $this->currentReviewId = $reviewId;
            $this->reviewImages = [asset('storage/' . $review->image)];
            $this->currentImageIndex = 0;
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

    public function startEditing($reviewId)
    {
        $review = $this->business->reviews()->findOrFail($reviewId);
        
        // Check if user is authorized to edit this review
        if (Auth::id() !== $review->user_id && !Auth::user()->isAdmin()) {
            return;
        }

        $this->editingReview = $review;
        $this->editComment = $review->comment;
        $this->editRating = $review->rating;
    }

    public function cancelEditing()
    {
        $this->editingReview = null;
        $this->editComment = '';
        $this->editRating = 0;
        $this->editImage = null;
    }

    public function updateReview()
    {
        if (!$this->editingReview) {
            return;
        }

        // Check if user is authorized to edit this review
        if (Auth::id() !== $this->editingReview->user_id && !Auth::user()->isAdmin()) {
            return;
        }

        $this->validate([
            'editComment' => 'required|min:10',
            'editRating' => 'required|integer|min:1|max:5',
            'editImage' => 'nullable|image|max:2048'
        ]);

        $data = [
            'comment' => $this->editComment,
            'rating' => $this->editRating,
        ];

        if ($this->editImage) {
            // Delete old image if exists
            if ($this->editingReview->image) {
                Storage::disk('public')->delete($this->editingReview->image);
            }
            $data['image'] = $this->editImage->store('reviews', 'public');
        }

        $this->editingReview->update($data);

        $this->cancelEditing();
        $this->refreshBusiness();
    }

    public function updatedEditImage()
    {
        $this->validate([
            'editImage' => 'image|max:2048'
        ]);
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
