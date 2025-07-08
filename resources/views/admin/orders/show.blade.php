@extends('admin.layouts.app')

@section('title', 'Order Details - #' . $order->id)

@section('admin_content')
    <div class="container-fluid">
        <h1>Order Details #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">Back to Orders</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">Order Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p><strong>Status:</strong>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto"
                                onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                                <option value="received" {{ $order->status == 'received' ? 'selected' : '' }}>Received
                                </option>
                            </select>
                        </form>
                        </p>
                        @if($order->stripe_transaction_id)
                            <p><strong>Stripe Transaction ID:</strong> {{ $order->stripe_transaction_id }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5>Customer Information</h5>
                        <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest User' }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Address:</strong>
                            {{ $order->address_line_1 }}{{ $order->address_line_2 ? ', ' . $order->address_line_2 : '' }}
                        </p>
                        <p><strong>City, State, Zip:</strong> {{ $order->city }}, {{ $order->state }},
                            {{ $order->zip_code }}</p>
                        <p><strong>Country:</strong> {{ $order->country }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Products Ordered</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (at time of order)</th>
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

        @if($order->payment)
            <div class="card">
                <div class="card-header">Payment Details</div>
                <div class="card-body">
                    <p><strong>Transaction ID:</strong> {{ $order->payment->transaction_id ?? 'N/A' }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment->payment_method) }}</p>
                    <p><strong>Amount Paid:</strong> ${{ number_format($order->payment->amount, 2) }}</p>
                    <p><strong>Payment Status:</strong> <span
                            class="badge {{ $order->payment->status === 'completed' ? 'bg-success' : ($order->payment->status === 'failed' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($order->payment->status) }}</span>
                    </p>
                    <p><strong>Payment Date:</strong> {{ $order->payment->created_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection