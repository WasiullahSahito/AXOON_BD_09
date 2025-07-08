@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $key => $banner)
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($banners as $key => $banner)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="container">
                        <div class="row p-5">
                            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                <img class="img-fluid" src="{{ asset('storage/' . $banner->image_path) }}"
                                    alt="{{ $banner->title }}">
                            </div>
                            <div class="col-lg-6 mb-0 d-flex align-items-center">
                                <div class="text-align-left align-self-center">
                                    <h1 class="h1 text-success"><b>{{ $banner->title }}</b></h1>
                                    <h3 class="h2">{{ $banner->subtitle }}</h3>
                                    <p>
                                        {{ $banner->description }}
                                    </p>
                                    @if($banner->link_url)
                                        <a href="{{ $banner->link_url }}" class="btn btn-success mt-3">Shop Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel"
            role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel"
            role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <!-- Start Categories of The Month -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Categories of The Month</h1>
                <p>
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-12 col-md-4 p-5 mt-3">
                    {{-- Placeholder image for category, replace with dynamic image if available in Category model --}}
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                        <img src="{{ asset('img/category_img_01.jpg') }}" class="rounded-circle img-fluid border"
                            alt="{{ $category->name }}">
                    </a>
                    <h5 class="text-center mt-3 mb-3">{{ $category->name }}</h5>
                    <p class="text-center"><a href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="btn btn-success">Go Shop</a></p>
                </div>
            @endforeach
        </div>
    </section>
    <!-- End Categories of The Month -->

    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Featured Product</h1>
                    <p>
                        Reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        Excepteur sint occaecat cupidatat non proident.
                    </p>
                </div>
            </div>
            <div class="row">
                @forelse($featuredProducts as $product)
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                            </a>
                            <div class="card-body">
                                <ul class="list-unstyled d-flex justify-content-between">
                                    <li>
                                        {{-- Static stars for now, can be dynamic with ratings later --}}
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                    </li>
                                    <li class="text-right text-muted">${{ number_format($product->price, 2) }}</li>
                                </ul>
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="h2 text-decoration-none text-dark">{{ $product->name }}</a>
                                <p class="card-text">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                                <p class="text-muted">Reviews ({{ rand(10, 100) }})</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No featured products available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Featured Product -->
@endsection