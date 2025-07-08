<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product; // Import the Banner model
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
                                                // Fetch categories for "Categories of The Month" section
        $categories = Category::take(3)->get(); // Fetch 3 categories for display

                                                     // Fetch featured products for "Featured Product" section
        $featuredProducts = Product::take(3)->get(); // Fetch 3 latest products as featured

                                                                              // Fetch active banners for the carousel
        $banners = Banner::where('is_active', true)->orderBy('order')->get(); // Fetch banners

        return view('home', compact('categories', 'featuredProducts', 'banners')); // Pass banners to the view
    }

    public function products(Request $request)
    {
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $products   = $query->paginate(9); // Paginate products, e.g., 9 per page
        $categories = Category::all();     // Fetch all categories for the sidebar filter

        return view('products', compact('products', 'categories'));
    }

    public function productDetail(Product $product)
    {
        // Load the product and its related category
        $product->load('category');
        return view('product_detail', compact('product'));
    }

    public function contact()
    {
        return view('contact');
    }
}
