<x-app-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Categories
            </a>
        </div>

        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="mt-2 text-gray-600">{{ $category->description }}</p>
                @endif
            </div>
            
            @if(auth()->check() && auth()->user()->isAdmin())
                <div>
                    <a href="{{ route('categories.edit', $category) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Edit Category
                    </a>
                </div>
            @endif
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Businesses in this Category</h2>

        @if($businesses->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No businesses found in this category.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($businesses as $business)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-semibold text-gray-800">
                                    <a href="{{ route('business.show', $business->id) }}" class="hover:text-blue-600">
                                        {{ $business->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center">
                                    <span class="text-amber-400">★</span>
                                    <span class="ml-1 text-gray-700">{{ number_format($business->avg_rating, 1) }}</span>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-600 line-clamp-2">{{ $business->description }}</p>
                            <div class="mt-3 text-sm text-gray-500">
                                <p>{{ $business->city }}, {{ $business->state }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $businesses->links() }}
            </div>
        @endif
    </div>
</x-app-layout> 