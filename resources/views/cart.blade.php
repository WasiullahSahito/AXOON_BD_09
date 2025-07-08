@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container py-5">
        <h1 class="h2 text-center pb-4">Shopping Cart</h1>

        @if (session('cart') && count(session('cart')) > 0)
            <div class="row">
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_price = 0; @endphp
                            @foreach (session('cart') as $id => $details)
                                @php $total_price += $details['price'] * $details['quantity']; @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $details['image']) }}" width="50" class="img-fluid me-2">
                                        {{ $details['name'] }}
                                    </td>
                                    <td>${{ number_format($details['price'], 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                                class="form-control w-50">
                                            <button type="submit" class="btn btn-sm btn-info ms-2">Update</button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                <td colspan="2"><strong>${{ number_format($total_price, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            Order Summary
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total:
                                    <span>${{ number_format($total_price, 2) }}</span>
                                </li>
                            </ul>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ url('/checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                                <a href="{{ url('/products') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                Your cart is empty. <a href="{{ url('/products') }}">Start shopping!</a>
            </div>
        @endif
    </div>
@endsection