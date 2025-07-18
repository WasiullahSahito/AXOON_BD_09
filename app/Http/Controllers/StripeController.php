<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_KEY'));
        $sessionId = $request->query('session_id');

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $orderId = $session->metadata->order_id;
                $order   = Order::find($orderId);

                if ($order) {
                    $order->status                = 'processing'; // Or 'received', depending on your flow
                    $order->stripe_transaction_id = $session->id;
                    $order->save();

                    // Update payment record
                    $payment = Payment::where('order_id', $order->id)->first();
                    if ($payment) {
                        $payment->transaction_id = $session->id;
                        $payment->status         = 'completed';
                        $payment->save();
                    }

                    session()->forget('cart'); // Clear the cart after successful payment

                    return redirect()->route('checkout.success')->with('success', 'Payment successful! Your order is being processed.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('error', 'Payment not successful or order not found.');
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');
        $order   = Order::find($orderId);

        if ($order) {
            // Optionally, update the order status to 'canceled' or 'pending payment'
            $order->status = 'canceled';
            $order->save();

            // Update payment record to failed
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->status = 'failed';
                $payment->save();
            }
        }
        return redirect()->route('cart.index')->with('error', 'Payment canceled. You can try again or choose another payment method.');
    }
}
