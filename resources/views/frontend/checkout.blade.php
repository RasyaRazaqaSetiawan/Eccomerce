@extends('layouts.frontend')

@section('content')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec checkout page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-checkout-leftside col-lg-8 col-md-12">
                    <!-- checkout content Start -->
                    <div class="ec-checkout-content">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ url('/checkout/shipment') }}" method="POST">
                            @csrf
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white">Shipping Method</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($shippingMethods as $method)
                                            <li class="list-group-item d-flex align-items-center border border-secondary rounded mb-2">
                                                <input type="radio" name="shipping_method" value="{{ $method['id'] }}" class="form-check-input me-3" required>
                                                <i class="ecicon {{ $method['icon'] ?? '' }} text-primary fs-4 me-3"></i>
                                                <div class="flex-grow-1">
                                                    <strong>{{ $method['name'] }}</strong>
                                                    <div class="text-muted">{{ number_format($method['price'], 0, ',', '.') }} IDR</div>
                                                    <small class="text-secondary">({{ $method['estimated'] }})</small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    @error('shipping_method')
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">
                                Place Order
                            </button>
                        </form>
                    </div>
                    <!-- checkout content End -->
                </div>

                <!-- Sidebar Area Start -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Summary</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary">
                                    <div class="ec-checkout-summary-total">
                                        <span class="text-left">Total Amount</span>
                                        <span class="text-right">{{ number_format($totalAmount, 0, ',', '.') }} IDR</span>
                                    </div>
                                </div>
                                <div class="ec-checkout-pro">
                                    @foreach($cartItems as $item)
                                        <div class="col-sm-12 mb-6">
                                            <div class="ec-product-inner">
                                                <div class="ec-pro-image-outer">
                                                    <div class="ec-pro-image">
                                                        <a href="{{ route('detail', ['category_slug' => $item->product->category->slug, 'product_slug' => $item->product->slug]) }}" class="image">
                                                            <img class="main-image" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ec-pro-content">
                                                    <h5 class="ec-pro-title">
                                                        <a href="{{ route('detail', ['category_slug' => $item->product->category->slug, 'product_slug' => $item->product->slug]) }}">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h5>
                                                    <span class="ec-price">
                                                        <span class="new-price">{{ number_format($item->product->price, 0, ',', '.') }} IDR</span>
                                                    </span>
                                                    <span class="ec-quantity">Qty: {{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
