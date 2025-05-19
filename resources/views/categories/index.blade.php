<x-app-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
            
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Add Category
                </a>
            @endif
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No categories found.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                        <div class="p-5">
                            <h3 class="text-xl font-semibold text-gray-800">
                                <a href="{{ route('categories.show', $category->id) }}" class="hover:text-blue-600">
                                    {{ $category->name }}
                                </a>
                            </h3>
                            @if($category->description)
                                <p class="mt-2 text-gray-600">{{ $category->description }}</p>
                            @endif
                            <p class="mt-3 text-sm text-gray-500">
                                {{ $category->businesses->count() }} {{ Str::plural('business', $category->businesses->count()) }}
                            </p>
                            
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="mt-4 flex">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                    
                                    @if($category->businesses->isEmpty())
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-app-layout> 