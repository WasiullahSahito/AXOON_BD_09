<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User; // Import the Banner model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalUsers    = User::count();
        $totalOrders   = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $topCustomers = User::select('users.name', DB::raw('SUM(orders.total) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();

        $topProducts = Product::select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity_sold')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalUsers', 'totalOrders', 'pendingOrders',
            'topCustomers', 'topProducts'
        ));
    }

    // Product Management
    public function products()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $imagePath,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'quantity'    => $request->quantity,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath      = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'quantity'    => $request->quantity,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    // User Management
    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|in:user,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    // Order Management
    public function orders()
    {
        $orders = Order::with('user', 'orderItems.product')->orderByDesc('created_at')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetails(Order $order)
    {
        $order->load('user', 'orderItems.product', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivered,canceled,received',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    // Banner Management (NEW)
    public function banners()
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function createBanner()
    {
        return view('admin.banners.create');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url'    => 'nullable|url|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'image_path'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is required for new banner
        ]);

        $imagePath = $request->file('image_path')->store('banners', 'public');

        Banner::create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'link_url'    => $request->link_url,
            'order'       => $request->order,
            'is_active'   => $request->has('is_active'), // Check if checkbox is checked
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }

    public function editBanner(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function updateBanner(Request $request, Banner $banner)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url'    => 'nullable|url|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'image_path'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional for update
        ]);

        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $imagePath = $request->file('image_path')->store('banners', 'public');
        } else {
            $imagePath = $banner->image_path; // Keep old image if no new one uploaded
        }

        $banner->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'link_url'    => $request->link_url,
            'order'       => $request->order,
            'is_active'   => $request->has('is_active'),
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function deleteBanner(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
