<?php

namespace App\Livewire;

use App\Models\Business;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class BusinessDetail extends Component
{
    public $business;
    public $image;
    public $isFeatured;

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

    public function render()
    {
        return view('livewire.business-detail', [
            'business' => $this->business->load(['reviews.user', 'category']),
            'isAdmin' => Auth::user()?->isAdmin() ?? false,
        ]);
    }
}
