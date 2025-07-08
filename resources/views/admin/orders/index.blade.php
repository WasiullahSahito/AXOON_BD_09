@extends('admin.layouts.app')

@section('title', 'Order Management')

@section('admin_content')
    <div class="container-fluid">
        <h1>Order Management</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Guest User' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td><span
                                class="badge {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'canceled' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i A') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View Details</a>
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection