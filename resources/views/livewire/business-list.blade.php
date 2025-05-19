<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Businesses Slider -->
        @if($featuredBusinesses->count() > 0)
            <div class="relative mb-12">
                <div class="swiper-container overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach($featuredBusinesses as $business)
                            <div class="swiper-slide">
                                <a href="{{ route('business.show', $business) }}" class="block">
                                    <div class="relative h-[500px] rounded-2xl overflow-hidden">
                                        @if($business->image)
                                            <img src="{{ asset('storage/' . $business->image) }}" 
                                                 alt="{{ $business->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700"></div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>
                                        
                                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                                            <div class="max-w-3xl mx-auto">
                                                <div class="flex items-center space-x-2 mb-4">
                                                    <span class="px-3 py-1 bg-blue-600 rounded-full text-sm font-medium">Featured</span>
                                                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">{{ $business->category->name }}</span>
                                                </div>
                                                <h2 class="text-4xl font-bold mb-4">{{ $business->name }}</h2>
                                                <p class="text-lg text-gray-200 mb-6 line-clamp-2">{{ $business->description }}</p>
                                                <div class="flex items-center space-x-6">
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-5 h-5 {{ $i <= $business->reviews_avg_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                        <span class="ml-2 text-sm">{{ number_format($business->reviews_avg_rating, 1) }} ({{ $business->reviews_count }} reviews)</span>
                                                    </div>
                                                    <div class="flex items-center text-sm">
                                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        {{ $business->city }}, {{ $business->state }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next !text-white"></div>
                    <div class="swiper-button-prev !text-white"></div>
                </div>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Search businesses..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select wire:model.live="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Businesses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($businesses as $business)
                <a href="{{ route('business.show', $business) }}" class="block">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 h-full">
                        @if($business->image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $business->image) }}" 
                                     alt="{{ $business->name }}" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                <span class="text-4xl text-white font-bold">{{ substr($business->name, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $business->name }}</h3>
                                @if($business->is_featured)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Featured</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $business->reviews_avg_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm text-gray-500">
                                    {{ number_format($business->reviews_avg_rating, 1) }} ({{ $business->reviews_count }} reviews)
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $business->description }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $business->city }}, {{ $business->state }}
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="mt-4 text-xl text-gray-500">No businesses found matching your criteria.</p>
                        <p class="mt-2 text-gray-500">Try adjusting your search or category filter.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $businesses->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function () {
            new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                watchSlidesProgress: true,
                preventInteractionOnTransition: true,
            });
        });
    </script>
    @endpush
</div>
