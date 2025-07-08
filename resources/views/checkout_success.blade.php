@extends('layouts.app')

@section('title', 'Order Placed Successfully')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header bg-success text-white">Order Confirmation</div>
                    <div class="card-body">
                        <h1 class="card-title text-success">Thank You for Your Order!</h1>
                        <p class="card-text lead">Your order has been placed successfully.</p>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <hr>
                        <p>We've sent a confirmation email to your registered email address.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-3">View My Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection