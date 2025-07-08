<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
// Make sure Category model is imported if used for cart details

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1); // Default to 1 if not provided

        // Ensure product exists
        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        // Get category name for display in cart
        $categoryName = $product->category ? $product->category->name : 'N/A';

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name"          => $product->name,
                "quantity"      => $quantity,
                "price"         => $product->price,
                "image"         => $product->image,
                "category_name" => $categoryName, // Store category name
            ];
        }

        session()->put('cart', $cart);

        // Optionally, you can redirect to the cart page or stay on the current page
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, $id)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Cart updated successfully');
            }
        }
        return redirect()->back();
    }

    public function removeCart(Request $request, $id)
    {
        if ($id) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
        return redirect()->back();
    }
}
