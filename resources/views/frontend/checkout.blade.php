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
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
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
                    <div class="ec-checkout-content">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Formulir Checkout -->
                        <form action="{{ url('/checkout/process') }}" method="POST">
                            @csrf
                            <!-- Pilihan Pengiriman -->
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

                            <!-- Ringkasan Pesanan -->
                            <div class="card mt-4 shadow-sm">
                                <div class="card-header bg-secondary">
                                    <h5 class="mb-0 text-white">Order Summary</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($cartItems as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $item->product->name }} (x{{ $item->quantity }})
                                                <span>{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }} IDR</span>
                                            </li>
                                        @endforeach
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Total</strong>
                                            <strong id="totalAmount">{{ number_format($totalAmount, 0, ',', '.') }} IDR</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Summary</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary">
                                    <div class="ec-checkout-summary-total">
                                        <span class="text-left">Total Amount</span>
                                        <span class="text-right" id="finalTotal">{{ number_format($totalAmount, 0, ',', '.') }} IDR</span>
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
                    </div>
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const shippingOptions = document.querySelectorAll("input[name='shipping_method']");
            const totalAmountEl = document.getElementById("totalAmount");
            const finalTotalEl = document.getElementById("finalTotal");
            let baseTotal = {{ $totalAmount }};

            shippingOptions.forEach(option => {
                option.addEventListener("change", function() {
                    let shippingCost = parseInt(this.closest("li").querySelector(".text-muted").textContent.replace(/\D/g, '')) || 0;
                    let finalTotal = baseTotal + shippingCost;
                    totalAmountEl.textContent = new Intl.NumberFormat('id-ID').format(finalTotal) + " IDR";
                    finalTotalEl.textContent = new Intl.NumberFormat('id-ID').format(finalTotal) + " IDR";
                });
            });
        });
    </script>
@endsection
