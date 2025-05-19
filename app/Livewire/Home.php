<?php

namespace App\Livewire;

use App\Models\Business;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredBusinesses = Business::with(['category', 'reviews'])
            ->featured()
            ->withAvg('reviews', 'rating')
            ->take(6)
            ->get();

        return view('livewire.home', [
            'featuredBusinesses' => $featuredBusinesses,
        ]);
    }
} 