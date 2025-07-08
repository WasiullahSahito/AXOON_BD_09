<?php
namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
// Make sure to import DB facade
use Illuminate\Support\Facades\DB;
use Database\Seeders\AdminUserSeeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Ensure users and products exist before creating orders
        $users    = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            // If users or products are missing, call their seeders
            $this->call(AdminUserSeeder::class);
            $this->call(CategorySeeder::class); // Ensure categories are there for products
            $this->call(ProductSeeder::class);

            // Re-fetch users and products after seeding
            $users    = User::all();
            $products = Product::all();
        }

        // Check again if users or products are still empty after attempting to seed
        if ($users->isEmpty() || $products->isEmpty()) {
            echo "Warning: No users or products found to create orders. Please ensure UserSeeder and ProductSeeder are working correctly.\n";
            return;
        }

        // Create some sample orders
        foreach ($users as $user) {
            // Each user places 1 to 3 orders
            for ($i = 0; $i < rand(1, 3); $i++) {
                // Ensure there are enough products to select from
                if ($products->count() < 1) {
                    echo "Warning: Not enough products to create order items for user " . $user->name . ".\n";
                    continue;
                }

                $order = Order::create([
                    'user_id'        => $user->id,
                    'total'          => 0, // Will be calculated based on items
                    'payment_method' => ['cod', 'stripe'][array_rand(['cod', 'stripe'])],
                    'status'         => ['pending', 'processing', 'delivered'][array_rand(['pending', 'processing', 'delivered'])],
                    'first_name'     => $user->name,
                    'last_name'      => 'User', // Placeholder last name
                    'email'          => $user->email,
                    'phone'          => '1234567890', // Placeholder phone
                    'address_line_1' => '123 Main St',
                    'city'           => 'Anytown',
                    'state'          => 'CA',
                    'zip_code'       => '90210',
                    'country'        => 'USA',
                ]);

                $orderTotal      = 0;
                $numItems        = rand(1, min(3, $products->count())); // Each order has 1-3 items, limited by available products
                $orderedProducts = $products->random($numItems);

                foreach ($orderedProducts as $product) {
                    $quantity = rand(1, 5);
                    // Ensure product quantity doesn't go below zero if you have stock tracking
                    // For seeding, we'll just add the item
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'price'      => $product->price,
                    ]);
                    $orderTotal += ($product->price * $quantity);
                }

                $order->total = $orderTotal;
                $order->save();

                // Create a payment record for the order
                Payment::create([
                    'order_id'       => $order->id,
                    'transaction_id' => $order->payment_method === 'stripe' ? 'STRIPE_TXN_' . Str::random(10) : null,
                    'payment_method' => $order->payment_method,
                    'amount'         => $orderTotal,
                    'status'         => $order->status === 'canceled' ? 'failed' : 'completed', // Simple logic for status
                ]);
            }
        }
    }
}
