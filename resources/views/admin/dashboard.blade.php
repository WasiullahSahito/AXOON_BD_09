@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('admin_content')
    <div class="container-fluid">
        <h1>Admin Dashboard</h1>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Products</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalProducts }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalUsers }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Orders</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalOrders }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Pending Orders</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pendingOrders }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Top 10 Customers by Purchase Total</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>${{ number_format($customer->total_spent, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No customer data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Top 10 Best-Selling Products by Quantity</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->total_quantity_sold }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No product sales data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection