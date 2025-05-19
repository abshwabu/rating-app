<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        // Create some sample images
        $images = [
            'business1.jpg',
            'business2.jpg',
            'business3.jpg',
            'business4.jpg',
            'business5.jpg',
        ];

        // Copy sample images to storage
        foreach ($images as $image) {
            if (!Storage::exists('public/businesses/' . $image)) {
                Storage::copy('sample-images/' . $image, 'public/businesses/' . $image);
            }
        }

        // Create businesses
        $categories = Category::all();
        $users = User::all();

        for ($i = 0; $i < 20; $i++) {
            Business::create([
                'name' => fake()->company(),
                'description' => fake()->paragraph(),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'zip_code' => fake()->postcode(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->companyEmail(),
                'website' => fake()->url(),
                'image' => 'businesses/' . $images[array_rand($images)],
                'is_featured' => fake()->boolean(20), // 20% chance of being featured
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
} 