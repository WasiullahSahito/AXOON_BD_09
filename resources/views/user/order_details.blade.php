@extends('layouts.app')

@section('title', 'Order Details - #' . $order->id)

@section('content')
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                Order Details #{{ $order->id }}
                <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-secondary float-end">Back to Dashboard</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Order Information</h5>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p><strong>Status:</strong> <span
                                class="badge {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'canceled' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($order->status) }}</span>
                        </p>
                        @if($order->stripe_transaction_id)
                            <p><strong>Stripe Transaction ID:</strong> {{ $order->stripe_transaction_id }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5>Shipping Information</h5>
                        <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Address:</strong> {{ $order->address_line_1 }}, {{ $order->address_line_2 }}</p>
                        <p><strong>City, State, Zip:</strong> {{ $order->city }}, {{ $order->state }},
                            {{ $order->zip_code }}</p>
                        <p><strong>Country:</strong> {{ $order->country }}</p>
                    </div>
                </div>

                <h5 class="mt-4">Products Ordered</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Product Not Found' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection