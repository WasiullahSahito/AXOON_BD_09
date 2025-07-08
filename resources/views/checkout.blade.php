@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Checkout</div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('checkout.place') }}" method="POST">
                            @csrf
                            <h4>Shipping Information</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required
                                        value="{{ old('first_name', session('user_id') ? \App\Models\User::find(session('user_id'))->name : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required
                                        value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        value="{{ old('email', session('user_id') ? \App\Models\User::find(session('user_id'))->email : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1" required
                                    value="{{ old('address_line_1') }}">
                            </div>
                            <div class="mb-3">
                                <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                    value="{{ old('address_line_2') }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" required
                                        value="{{ old('city') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state" required
                                        value="{{ old('state') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" required
                                        value="{{ old('zip_code') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" required
                                    value="{{ old('country') }}">
                            </div>

                            <h4 class="mt-4">Payment Method</h4>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                        checked>
                                    <label class="form-check-label" for="cod">
                                        Cash on Delivery (COD)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="stripe"
                                        value="stripe">
                                    <label class="form-check-label" for="stripe">
                                        Credit Card (Stripe)
                                    </label>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection