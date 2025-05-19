<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Find the Best Local Businesses</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Discover and review local businesses in your area. Share your experiences and help others make informed decisions.</p>
        </div>

        <!-- Featured Businesses Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Businesses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredBusinesses as $business)
                    <a href="{{ route('business.show', $business->id) }}" class="block group">
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm group-hover:shadow-md transition-all duration-200 h-full flex flex-col">
                            @if($business->image)
                                <div class="h-48 overflow-hidden rounded-t-lg">
                                    <img src="{{ $business->image_url }}" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                </div>
                            @endif
                            <div class="p-5 flex-1">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                        {{ $business->name }}
                                    </h3>
                                    <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-lg">
                                        <span class="text-yellow-500 text-lg">★</span>
                                        <span class="ml-1 font-medium text-gray-700">{{ number_format($business->avg_rating, 1) }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $business->category->name }}
                                </div>
                                
                                <p class="mt-3 text-gray-600 line-clamp-3">{{ $business->description }}</p>
                                
                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p>{{ $business->city }}, {{ $business->state }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Ready to Share Your Experience?</h2>
            <p class="text-lg mb-8">Join our community and start reviewing local businesses today.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Sign Up Now
                </a>
                <a href="{{ route('businesses.index') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-indigo-700 transition-colors">
                    Browse Businesses
                </a>
            </div>
        </div>
    </div>
</div> 