<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Restaurants', 'description' => 'Places to eat and dine'],
            ['name' => 'Shopping', 'description' => 'Retail stores and malls'],
            ['name' => 'Services', 'description' => 'Professional and personal services'],
            ['name' => 'Nightlife', 'description' => 'Bars, clubs, and entertainment'],
            ['name' => 'Beauty & Spas', 'description' => 'Salons, spas, and wellness centers'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create sample businesses
        $businesses = [
            [
                'name' => 'Delicious Bites',
                'description' => 'A fine dining restaurant with a wide variety of cuisines.',
                'address' => '123 Food Street',
                'city' => 'Foodville',
                'state' => 'FD',
                'zip_code' => '12345',
                'phone' => '123-456-7890',
                'website' => 'https://deliciousbites.example.com',
                'email' => 'info@deliciousbites.example.com',
                'category_id' => 1,
                'user_id' => $user->id,
                'is_featured' => true,
                'image' => 'businesses/restaurant.jpg',
            ],
            [
                'name' => 'Fashion Hub',
                'description' => 'One-stop shop for all your fashion needs.',
                'address' => '456 Shopping Avenue',
                'city' => 'Shopville',
                'state' => 'SH',
                'zip_code' => '23456',
                'phone' => '234-567-8901',
                'website' => 'https://fashionhub.example.com',
                'email' => 'info@fashionhub.example.com',
                'category_id' => 2,
                'user_id' => $user->id,
                'is_featured' => true,
                'image' => 'businesses/shopping.jpg',
            ],
            [
                'name' => 'Quick Fix Services',
                'description' => 'Professional repair and maintenance services.',
                'address' => '789 Service Road',
                'city' => 'Fixtown',
                'state' => 'FX',
                'zip_code' => '34567',
                'phone' => '345-678-9012',
                'website' => 'https://quickfix.example.com',
                'email' => 'info@quickfix.example.com',
                'category_id' => 3,
                'user_id' => $user->id,
                'is_featured' => false,
                'image' => 'businesses/services.jpg',
            ],
            [
                'name' => 'Night Owl Club',
                'description' => 'The best nightclub in town with great music and drinks.',
                'address' => '101 Party Street',
                'city' => 'Funtown',
                'state' => 'FN',
                'zip_code' => '45678',
                'phone' => '456-789-0123',
                'website' => 'https://nightowl.example.com',
                'email' => 'info@nightowl.example.com',
                'category_id' => 4,
                'user_id' => $user->id,
                'is_featured' => true,
                'image' => 'businesses/nightclub.jpg',
            ],
            [
                'name' => 'Relaxation Spa',
                'description' => 'Luxury spa treatments for ultimate relaxation.',
                'address' => '202 Wellness Way',
                'city' => 'Spaville',
                'state' => 'SP',
                'zip_code' => '56789',
                'phone' => '567-890-1234',
                'website' => 'https://relaxationspa.example.com',
                'email' => 'info@relaxationspa.example.com',
                'category_id' => 5,
                'user_id' => $user->id,
                'is_featured' => true,
                'image' => 'businesses/spa.jpg',
            ],
        ];

        $createdBusinesses = [];
        foreach ($businesses as $businessData) {
            $createdBusinesses[] = Business::create($businessData);
        }

        // Create sample reviews
        $reviews = [
            [
                'user_id' => $user->id,
                'business_id' => $createdBusinesses[0]->id,
                'rating' => 5,
                'comment' => 'Amazing food and great service! Will definitely come back.',
                'image' => 'reviews/restaurant-review.jpg',
            ],
            [
                'user_id' => $user->id,
                'business_id' => $createdBusinesses[1]->id,
                'rating' => 4,
                'comment' => 'Good selection of clothes and helpful staff.',
                'image' => 'reviews/shopping-review.jpg',
            ],
            [
                'user_id' => $user->id,
                'business_id' => $createdBusinesses[2]->id,
                'rating' => 3,
                'comment' => 'The service was okay, but took longer than expected.',
                'image' => 'reviews/services-review.jpg',
            ],
            [
                'user_id' => $user->id,
                'business_id' => $createdBusinesses[3]->id,
                'rating' => 5,
                'comment' => 'Best club in town! Great atmosphere and music.',
                'image' => 'reviews/nightclub-review.jpg',
            ],
            [
                'user_id' => $user->id,
                'business_id' => $createdBusinesses[4]->id,
                'rating' => 4,
                'comment' => 'Very relaxing experience. The massage was excellent.',
                'image' => 'reviews/spa-review.jpg',
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        // Update total ratings for businesses
        foreach ($createdBusinesses as $business) {
            $totalRating = Review::where('business_id', $business->id)->sum('rating');
            $business->update(['total_rating' => $totalRating]);
        }
    }
}
