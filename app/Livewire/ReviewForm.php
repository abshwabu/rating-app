<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ReviewForm extends Component
{
    use WithFileUploads;

    public Business $business;
    public $rating = 0;
    public $comment = '';
    public $image;
    public $tempImage;
    public $hasReviewed = false;

    public function mount(Business $business)
    {
        $this->business = $business;
        
        // Check if user has already reviewed this business
        $existingReview = $business->reviews()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            $this->rating = $existingReview->rating;
            $this->comment = $existingReview->comment;
            $this->tempImage = $existingReview->image;
            $this->hasReviewed = true;
        }
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:10240', // 1MB Max
        ]);
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function saveReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:10',
            'image' => 'nullable|image|max:10240', // 1MB Max
        ]);

        $reviewData = [
            'rating' => $this->rating,
            'comment' => $this->comment,
            'user_id' => auth()->id(),
        ];

        // Handle image upload
        if ($this->image) {
            // Delete old image if exists
            if ($this->tempImage) {
                Storage::disk('public')->delete($this->tempImage);
            }
            
            $reviewData['image'] = $this->image->store('reviews', 'public');
        }

        // Update or create review
        $review = $this->business->reviews()
            ->updateOrCreate(
                ['user_id' => auth()->id()],
                $reviewData
            );

        // Reset form
        $this->reset(['rating', 'comment', 'image']);
        $this->tempImage = $review->image;
        $this->hasReviewed = true;

        // Emit event to refresh business data
        $this->dispatch('reviewAdded');

        session()->flash('message', 'Review saved successfully!');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
