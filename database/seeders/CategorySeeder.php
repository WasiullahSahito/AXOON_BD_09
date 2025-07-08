<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Apparel',
            'Books',
            'Home & Kitchen',
            'Sports & Outdoors',
            'Beauty & Personal Care',
            'Cosmetics', // Ensure these are consistent with ProductSeeder
            'Jewelry',   // Ensure these are consistent with ProductSeeder
        ];

        foreach ($categories as $categoryName) {
            // Only create the category if it doesn't already exist
            Category::firstOrCreate(
                ['name' => $categoryName],          // Attributes to check for existence
                ['slug' => Str::slug($categoryName)]// Attributes to create if not found
            );
        }
    }
}
