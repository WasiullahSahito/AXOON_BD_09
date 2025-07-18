<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! session()->has('cart') || count(session('cart')) === 0) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }
        return view('checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:255',
            'zip_code'       => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create the order
        $order                 = new Order();
        $order->user_id        = session('user_id'); // Assuming user is logged in
        $order->total          = $total;
        $order->payment_method = $request->payment_method;
        $order->status         = 'pending';
        $order->first_name     = $request->first_name;
        $order->last_name      = $request->last_name;
        $order->email          = $request->email;
        $order->phone          = $request->phone;
        $order->address_line_1 = $request->address_line_1;
        $order->address_line_2 = $request->address_line_2;
        $order->city           = $request->city;
        $order->state          = $request->state;
        $order->zip_code       = $request->zip_code;
        $order->country        = $request->country;
        $order->save();

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $details['quantity'],
                'price'      => $details['price'],
            ]);
            // Decrease product quantity in stock
            $product = Product::find($id);
            if ($product) {
                $product->quantity -= $details['quantity'];
                $product->save();
            }
        }

        if ($request->payment_method === 'cod') {
            session()->forget('cart');
            return redirect()->route('checkout.success')->with('success', 'Order placed successfully with Cash on Delivery!');
        } elseif ($request->payment_method === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $line_items = [];
            foreach ($cart as $id => $details) {
                $line_items[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'   => $details['name'],
                            'images' => [asset('storage/' . $details['image'])],
                        ],
                        'unit_amount'  => $details['price'] * 100, // Amount in cents
                    ],
                    'quantity'   => $details['quantity'],
                ];
            }

            try {
                $checkoutSession = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items'           => $line_items,
                    'mode'                 => 'payment',
                    'success_url'          => route('stripe.success', ['order_id' => $order->id]),
                    'cancel_url'           => route('stripe.cancel', ['order_id' => $order->id]),
                    'metadata'             => [
                        'order_id' => $order->id,
                        'user_id'  => $order->user_id,
                    ],
                ]);

                // Store payment record as pending
                Payment::create([
                    'order_id'       => $order->id,
                    'payment_method' => 'stripe',
                    'amount'         => $total,
                    'status'         => 'pending',
                ]);

                return redirect()->away($checkoutSession->url);

            } catch (\Exception $e) {
                                  // If Stripe checkout fails, revert the order and cart
                $order->delete(); // Delete the created order
                foreach ($cart as $id => $details) {
                    $product = Product::find($id);
                    if ($product) {
                        $product->quantity += $details['quantity']; // Add back quantity to stock
                        $product->save();
                    }
                }
                return redirect()->back()->with('error', 'Error processing Stripe payment: ' . $e->getMessage());
            }
        }

        return redirect()->route('home')->with('error', 'Something went wrong with the order.');
    }

    public function checkoutSuccess(Request $request)
    {
        return view('checkout_success');
    }
}
