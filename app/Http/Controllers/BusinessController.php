<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the businesses.
     */
    public function index()
    {
        return view('businesses.index');
    }

    /**
     * Show the form for creating a new business.
     */
    public function create()
    {
        return view('businesses.create');
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business)
    {
        return view('businesses.show', compact('business'));
    }

    /**
     * Show the form for editing the specified business.
     */
    public function edit(Business $business)
    {
        // Check if the user has permission to edit this business
        if (auth()->id() !== $business->user_id && !auth()->user()?->isAdmin()) {
            return redirect()->route('businesses.show', $business)
                ->with('error', 'You do not have permission to edit this business.');
        }

        return view('businesses.edit', compact('business'));
    }
}
