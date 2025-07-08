<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function dashboard()
    {
        // Ensure user is logged in via session
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = User::find(session('user_id'));
        if (! $user) {
            // If user somehow not found in DB despite session, clear session and redirect
            session()->forget('user_id');
            return redirect()->route('login')->with('error', 'User not found. Please log in again.');
        }

        $orders = $user->orders()->orderByDesc('created_at')->get();
        return view('user.dashboard', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        // Ensure user is logged in via session
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = User::find(session('user_id'));
        if (! $user) {
            session()->forget('user_id');
            return redirect()->route('login')->with('error', 'User not found. Please log in again.');
        }

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password'     => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('current_password') && ! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Your current password does not match.'],
            ]);
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function orderDetails(Order $order)
    {
        // Ensure user is logged in via session
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = User::find(session('user_id'));
        if (! $user || $order->user_id !== $user->id) {
            return redirect()->route('user.dashboard')->with('error', 'Order not found or you do not have permission to view it.');
        }
        return view('user.order_details', compact('order'));
    }
}
