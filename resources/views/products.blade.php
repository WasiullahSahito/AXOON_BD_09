@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-3">
                <h1 class="h2 pb-4">Categories</h1>
                <ul class="list-unstyled templatemo-accordion">
                    @foreach($categories as $category)
                        <li class="pb-3">
                            {{-- Link to filter products by this category --}}
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none"
                                href="{{ route('products.index', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                                <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            {{-- Add subcategories if needed --}}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3"
                                    href="{{ route('products.index') }}">All</a>
                            </li>
                            {{-- You can add specific links for Men's/Women's if you have a gender attribute or
                            subcategories --}}
                            {{-- Example: <li class="list-inline-item"><a class="h3 text-dark text-decoration-none mr-3"
                                    href="{{ route('products.index', ['gender' => 'men']) }}">Men's</a></li> --}}
                            {{-- Example: <li class="list-inline-item"><a class="h3 text-dark text-decoration-none"
                                    href="{{ route('products.index', ['gender' => 'women']) }}">Women's</a></li> --}}
                        </ul>
                    </div>
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control">
                                <option>Featured</option>
                                <option>A to Z</option>
                                <option>Item</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}">
                                    <div
                                        class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            {{-- Heart icon to product detail --}}
                                            <li><a class="btn btn-success text-white"
                                                    href="{{ route('products.show', $product->id) }}"><i
                                                        class="far fa-heart"></i></a></li>
                                            {{-- Eye icon to product detail --}}
                                            <li><a class="btn btn-success text-white mt-2"
                                                    href="{{ route('products.show', $product->id) }}"><i
                                                        class="far fa-eye"></i></a></li>
                                            {{-- Add to Cart button with quantity 1 --}}
                                            <li>
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1"> {{-- Set quantity to 1 --}}
                                                    <button type="submit" class="btn btn-success text-white mt-2"><i
                                                            class="fas fa-cart-plus"></i></button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product->id) }}"
                                        class="h3 text-decoration-none">{{ $product->name }}</a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        {{-- You might replace this with actual product size if available --}}
                                        <li>M/L/X/XL</li>
                                        <li class="pt-2">
                                            {{-- Placeholder for colors, replace with dynamic if available --}}
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span
                                                class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span
                                                class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span
                                                class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span
                                                class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        {{-- Static stars for now, can be dynamic with ratings later --}}
                                        <li>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No products found in this category.</p>
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        {{ $products->links() }}
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- End Content -->
@endsection