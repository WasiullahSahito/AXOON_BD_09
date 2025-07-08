@extends('layouts.app')

@section('title', 'My Account')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('user.dashboard') }}"
                        class="list-group-item list-group-item-action active">Dashboard</a>
                    <a href="#profile-section" class="list-group-item list-group-item-action">Profile Information</a>
                    <a href="#orders-section" class="list-group-item list-group-item-action">Order History</a>
                </div>
            </div>
            <div class="col-md-9">
                <h1>Welcome, {{ $user->name }}!</h1>

                @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <div id="profile-section" class="card mt-4">
                    <div class="card-header">Profile Information</div>
                    <div class="card-body">
                        <form action="{{ route('user.profile.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <h5>Update Password (Optional)</h5>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </form>
                    </div>
                </div>

                <div id="orders-section" class="card mt-4">
                    <div class="card-header">Order History</div>
                    <div class="card-body">
                        @if($orders->isEmpty())
                            <p>You haven't placed any orders yet.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td><span
                                                    class="badge {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'canceled' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.orders.show', $order->id) }}"
                                                    class="btn btn-info btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection