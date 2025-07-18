<div>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $isEdit ? 'Edit Business' : 'Add New Business' }}
        </h1>

        @if(session('success'))
            <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-800 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="saveBusiness">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Business Name *</label>
                    <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div class="md:col-span-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select id="category_id" wire:model="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select a Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea id="description" wire:model="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Business Image</label>
                    <div class="mt-1 flex flex-col items-center">
                        <div class="w-full max-w-md">
                            <div class="relative group">
                                <div class="w-full h-64 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg">
                                    @elseif ($tempImage)
                                        <img src="{{ asset('storage/' . $tempImage) }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                                    @endif
                                </div>
                                <input type="file" 
                                       id="image" 
                                       wire:model="image" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       accept="image/*">
                            </div>
                        </div>
                        @error('image') 
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                    <input type="text" id="address" wire:model="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                    <input type="text" id="city" wire:model="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    @error('city') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                    <input type="text" id="state" wire:model="state" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    @error('state') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Zip Code -->
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                    <input type="text" id="zip_code" wire:model="zip_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('zip_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="phone" wire:model="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-gray-700 font-medium mb-2">Website (Optional)</label>
                    <input type="url" wire:model="website" id="website" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    @error('website') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ $isEdit ? 'Update Business' : 'Add Business' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
