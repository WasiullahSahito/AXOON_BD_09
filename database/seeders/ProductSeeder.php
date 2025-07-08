<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Ensure categories exist before creating products
$cosmeticsCategory   = Category::where('name', 'Cosmetics')->first();
$jewelryCategory     = Category::where('name', 'Jewelry')->first();
$electronicsCategory = Category::where('name', 'Electronics')->first();
$apparelCategory     = Category::where('name', 'Apparel')->first();
$booksCategory       = Category::where('name', 'Books')->first();

// If categories don't exist, run CategorySeeder first
if (! $cosmeticsCategory || ! $jewelryCategory || ! $electronicsCategory || ! $apparelCategory || ! $booksCategory) {
    $this->call(CategorySeeder::class);
    $cosmeticsCategory   = Category::where('name', 'Cosmetics')->first();
    $jewelryCategory     = Category::where('name', 'Jewelry')->first();
    $electronicsCategory = Category::where('name', 'Electronics')->first();
    $apparelCategory     = Category::where('name', 'Apparel')->first();
    $booksCategory       = Category::where('name', 'Books')->first();
}

// Create 5-10 demo products
Product::create([
    'category_id' => $cosmeticsCategory->id ?? null,
    'name'        => 'Luxury Lipstick',
    'description' => 'Vibrant, long-lasting lipstick for a perfect pout.',
    'image'       => 'products/lipstick.jpg', // Placeholder image path
    'price'       => 25.00,
    'quantity'    => 100,
]);

Product::create([
    'category_id' => $jewelryCategory->id ?? null,
    'name'        => 'Diamond Necklace',
    'description' => 'Elegant diamond necklace, perfect for special occasions.',
    'image'       => 'products/necklace.jpg', // Placeholder image path
    'price'       => 599.99,
    'quantity'    => 20,
]);

Product::create([
    'category_id' => $electronicsCategory->id ?? null,
    'name'        => 'Wireless Headphones',
    'description' => 'High-quality wireless headphones with noise cancellation.',
    'image'       => 'products/headphones.jpg',
    'price'       => 99.99,
    'quantity'    => 150,
]);

Product::create([
    'category_id' => $apparelCategory->id ?? null,
    'name'        => 'Men\'s Casual Shirt',
    'description' => 'Comfortable cotton shirt for everyday wear.',
    'image'       => 'products/mens_shirt.jpg',
    'price'       => 35.00,
    'quantity'    => 200,
]);

Product::create([
    'category_id' => $booksCategory->id ?? null,
    'name'        => 'Fantasy Novel Series',
    'description' => 'An epic fantasy adventure across mystical lands.',
    'image'       => 'products/fantasy_book.jpg',
    'price'       => 18.75,
    'quantity'    => 75,
]);

Product::create([
    'category_id' => $cosmeticsCategory->id ?? null,
    'name'        => 'Organic Face Serum',
    'description' => 'Nourishing serum with natural ingredients for glowing skin.',
    'image'       => 'products/face_serum.jpg',
    'price'       => 45.00,
    'quantity'    => 80,
]);

Product::create([
    'category_id' => $jewelryCategory->id ?? null,
    'name'        => 'Silver Hoop Earrings',
    'description' => 'Stylish and lightweight sterling silver hoop earrings.',
    'image'       => 'products/hoop_earrings.jpg',
    'price'       => 75.00,
    'quantity'    => 120,
]);

Product::create([
    'category_id' => $electronicsCategory->id ?? null,
    'name'        => 'Portable Power Bank',
    'description' => 'High-capacity power bank for charging devices on the go.',
    'image'       => 'products/power_bank.jpg',
    'price'       => 30.00,
    'quantity'    => 250,
]);

Product::create([
    'category_id' => $apparelCategory->id ?? null,
    'name'        => 'Women\'s Yoga Pants',
    'description' => 'Stretchy and comfortable yoga pants for active lifestyles.',
    'image'       => 'products/yoga_pants.jpg',
    'price'       => 28.00,
    'quantity'    => 180,
]);

Product::create([
    'category_id' => $booksCategory->id ?? null,
    'name'        => 'Cookbook: Italian Delights',
    'description' => 'A collection of authentic Italian recipes for home cooks.',
    'image'       => 'products/cookbook.jpg',
    'price'       => 22.00,
    'quantity'    => 60,
]);

    }
}
