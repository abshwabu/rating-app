<div>
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section with Image -->
        <div class="relative h-96">
            @if($image)
                <img src="{{ asset('storage/' . $image) }}" alt="{{ $business->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            @else
                <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                    <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            
            <!-- Business Info Overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-2">{{ $business->name }}</h1>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">{{ $business->category->name }}</span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $business->average_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm">{{ number_format($business->average_rating, 1) }} ({{ $business->reviews_count }} reviews)</span>
                                </div>
                            </div>
                        </div>
                        @if($isAdmin)
                            <div class="flex items-center space-x-2">
                                <span class="text-sm">Featured</span>
                                <button wire:click="toggleFeatured" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 {{ $isFeatured ? 'bg-blue-600' : 'bg-gray-200' }}">
                                    <span class="sr-only">Toggle featured status</span>
                                    <span class="translate-x-0 pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $isFeatured ? 'translate-x-5' : 'translate-x-0' }}">
                                        <span class="opacity-100 duration-200 ease-in absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $isFeatured ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in' }}" aria-hidden="true">
                                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="opacity-0 duration-100 ease-out absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $isFeatured ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out' }}" aria-hidden="true">
                                            <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                            </svg>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Description and Reviews -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Description -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">About</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $business->description ?: 'No description available.' }}</p>
                    </div>

                    <!-- Add Review Section -->
                    @auth
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Write a Review</h2>
                            <livewire:review-form :business="$business" />
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="text-center">
                                <p class="text-gray-600 mb-4">Please log in to write a review.</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Log in to Review
                                </a>
                            </div>
                        </div>
                    @endauth

                    <!-- Reviews Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Reviews</h2>
                            <div class="flex items-center space-x-4">
                                <select wire:model.live="ratingFilter" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Ratings</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4+ Stars</option>
                                    <option value="3">3+ Stars</option>
                                    <option value="2">2+ Stars</option>
                                    <option value="1">1+ Stars</option>
                                </select>
                                <select wire:model.live="sortReviews" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="latest">Latest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="highest">Highest Rated</option>
                                    <option value="lowest">Lowest Rated</option>
                                </select>
                            </div>
                        </div>

                        @if($reviews->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                <p class="mt-4 text-xl text-gray-500">No reviews yet</p>
                                <p class="mt-2 text-gray-500">Be the first to review this business!</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($reviews as $review)
                                    <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                        <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if(Auth::id() === $review->user_id || Auth::user()?->isAdmin())
                                                        <button wire:click="startEditing({{ $review->id }})" 
                                                                class="text-blue-600 hover:text-blue-800 text-sm">
                                                            Edit
                                                        </button>
                                                    @endif
                                                </div>

                                                @if($editingReview && $editingReview->id === $review->id)
                                                    <div class="mt-4 space-y-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                                                            <div class="flex items-center mt-1">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <button wire:click="$set('editRating', {{ $i }})" 
                                                                            class="focus:outline-none">
                                                                        <svg class="w-8 h-8 {{ $i <= $editRating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                                             fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                        </svg>
                                                                    </button>
                                                                @endfor
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label for="editComment" class="block text-sm font-medium text-gray-700">Comment</label>
                                                            <textarea wire:model="editComment" 
                                                                      id="editComment" 
                                                                      rows="3" 
                                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                                            @error('editComment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>

                                                        <div>
                                                            <label for="editImage" class="block text-sm font-medium text-gray-700">Image</label>
                                                            <input type="file" 
                                                                   wire:model="editImage" 
                                                                   id="editImage" 
                                                                   class="mt-1 block w-full text-sm text-gray-500
                                                                          file:mr-4 file:py-2 file:px-4
                                                                          file:rounded-md file:border-0
                                                                          file:text-sm file:font-semibold
                                                                          file:bg-blue-50 file:text-blue-700
                                                                          hover:file:bg-blue-100">
                                                            @error('editImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>

                                                        <div class="flex justify-end space-x-3">
                                                            <button wire:click="cancelEditing" 
                                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                Cancel
                                                            </button>
                                                            <button wire:click="updateReview" 
                                                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-gray-900">{{ $review->comment }}</p>
                                                    @if($review->image)
                                                        <div class="mt-4">
                                                            <img src="{{ asset('storage/' . $review->image) }}" 
                                                                 alt="Review image" 
                                                                 class="rounded-lg max-h-48 object-cover cursor-pointer hover:opacity-90 transition-opacity duration-200"
                                                                 wire:click="showImage({{ $review->id }})">
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 ml-4">
                                                {{ $review->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Contact Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                        <div class="space-y-4">
                            @if($business->address)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">Address</p>
                                        <p class="text-gray-600">{{ $business->address }}</p>
                                        <p class="text-gray-600">{{ $business->city }}, {{ $business->state }} {{ $business->zip_code }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($business->phone)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">Phone</p>
                                        <p class="text-gray-600">{{ $business->phone }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($business->email)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">Email</p>
                                        <p class="text-gray-600">{{ $business->email }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($business->website)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">Website</p>
                                        <a href="{{ $business->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $business->website }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    @if($showImageModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showImageModal', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-transparent rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="relative">
                    <!-- Close Button -->
                    <button type="button" 
                            class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none z-10"
                            wire:click="$set('showImageModal', false)">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Image -->
                    <div class="p-4">
                        <img src="{{ $reviewImages[$currentImageIndex] }}" 
                             class="w-full h-auto max-h-[80vh] object-contain">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
