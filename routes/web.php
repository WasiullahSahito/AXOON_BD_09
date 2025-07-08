<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;

// Frontend Routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/products', [FrontendController::class, 'products'])->name('products.index');
Route::get('/products/{product}', [FrontendController::class, 'productDetail'])->name('products.show');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/about', [FrontendController::class, 'about'])->name('about');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeCart'])->name('cart.remove');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');

// Stripe Routes
Route::get('stripe/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

// Authentication Routes (using session for simplicity as per request)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User Dashboard Routes (protected)
// Use the aliased middleware 'checkUserSession' directly
Route::middleware('checkUserSession')->group(function () {
    Route::get('/my-account', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/my-account/profile-update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/my-account/orders/{order}', [UserController::class, 'orderDetails'])->name('user.orders.show');
});

// Admin Routes (protected by AdminMiddleware)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Product Management
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Category Management
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderDetails'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
});

// Removed the redundant anonymous middleware definition
// Route::middleware(function (Illuminate\Http\Request $request, Closure $next) {
//     if (! session()->has('user_id')) {
//         return redirect()->route('login')->with('error', 'Please log in to access this page.');
//     }
//     return $next($request);
// })->name('checkUserSession'); // This was causing the error

// If you need a contact form submission, add a route for it
Route::post('/contact', function (Request $request) {
    // Handle contact form submission (e.g., send email)
    return redirect()->back()->with('success', 'Your message has been sent!');
})->name('contact.send');

// Banner Management
Route::get('/banners', [AdminController::class, 'banners'])->name('admin.banners.index');
Route::get('/banners/create', [AdminController::class, 'createBanner'])->name('admin.banners.create');
Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
Route::get('/banners/{banner}/edit', [AdminController::class, 'editBanner'])->name('admin.banners.edit');
Route::put('/banners/{banner}', [AdminController::class, 'updateBanner'])->name('admin.banners.update');
Route::delete('/banners/{banner}', [AdminController::class, 'deleteBanner'])->name('admin.banners.delete');
