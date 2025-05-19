<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessForm extends Component
{
    use WithFileUploads;

    public $business;
    public $businessId;
    public $name;
    public $description;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $phone;
    public $website;
    public $email;
    public $category_id;
    public $image;
    public $tempImage;
    
    public $isEdit = false;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:100',
            'description' => 'nullable|max:1000',
            'address' => 'required|max:200',
            'city' => 'required|max:100',
            'state' => 'nullable|max:50',
            'zip_code' => 'nullable|max:20',
            'phone' => 'nullable|max:20',
            'website' => 'nullable|url|max:200',
            'email' => 'nullable|email|max:100',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:1024', // max 1MB
        ];
    }

    public function mount(Business $business = null)
    {
        if ($business && $business->exists) {
            $this->business = $business;
            $this->businessId = $business->id;
            $this->name = $business->name;
            $this->description = $business->description;
            $this->address = $business->address;
            $this->city = $business->city;
            $this->state = $business->state;
            $this->zip_code = $business->zip_code;
            $this->phone = $business->phone;
            $this->website = $business->website;
            $this->email = $business->email;
            $this->category_id = $business->category_id;
            $this->tempImage = $business->image;
            $this->isEdit = true;
        }
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
    }

    public function saveBusiness()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'website' => $this->website,
            'email' => $this->email,
            'category_id' => $this->category_id,
        ];

        if ($this->image) {
            // Delete old image if exists
            if ($this->isEdit && $this->business->image) {
                Storage::disk('public')->delete($this->business->image);
            }
            
            // Store new image
            $data['image'] = $this->image->store('businesses', 'public');
        }

        if ($this->isEdit) {
            // Update existing business
            if ($this->business->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                session()->flash('error', 'You do not have permission to edit this business.');
                return;
            }
            
            $this->business->update($data);
            session()->flash('success', 'Business updated successfully!');
        } else {
            // Create new business
            $data['user_id'] = Auth::id();
            
            $business = Business::create($data);
            $this->business = $business;
            $this->businessId = $business->id;
            $this->isEdit = true;
            
            session()->flash('success', 'Business added successfully!');
        }

        return redirect()->route('business.show', $this->business);
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.business-form', [
            'categories' => $categories,
        ]);
    }
}
