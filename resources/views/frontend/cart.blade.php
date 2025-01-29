@extends('layouts.frontend')

@section('content')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Cart</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Cart</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec cart page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-cart-leftside col-lg-8 col-md-12 ">
                    <!-- cart content Start -->
                    <div class="ec-cart-content">
                        <div class="ec-cart-inner">
                            <div class="row">
                                <form action="{{ route('cart.update') }}" method="POST" id="cart-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="table-content cart-table-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th style="text-align: center;">Quantity</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cart as $cart_item)
                                                    <tr data-id="{{ $cart_item->id }}">
                                                        <td class="ec-cart-pro-name">
                                                            <img class="ec-cart-pro-img mr-4"
                                                                src="{{ $products[$cart_item->product_id]->image ? asset('storage/' . $products[$cart_item->product_id]->image) : asset('backend/assets/media/svg/files/blank-image.svg') }}"
                                                                alt="" />
                                                            {{ $products[$cart_item->product_id]->name }}
                                                        </td>
                                                        <td class="ec-cart-pro-price">
                                                            <span class="amount">Rp
                                                                {{ number_format($products[$cart_item->product_id]->price, 0, ',', '.') }}</span>
                                                            <input type="hidden" class="product-price"
                                                                value="{{ $products[$cart_item->product_id]->price }}">
                                                        </td>
                                                        <td class="ec-cart-pro-qty" style="text-align: center;">
                                                            <div class="cart-qty-plus-minus">
                                                                <input class="cart-plus-minus quantity" type="text"
                                                                    value="{{ $cart_item->quantity }}" readonly />
                                                            </div>
                                                        </td>
                                                        <td class="ec-cart-pro-subtotal">
                                                            Rp <span
                                                                class="subtotal">{{ number_format($products[$cart_item->product_id]->price * $cart_item->quantity, 0, ',', '.') }}</span>
                                                        </td>
                                                        <td class="ec-cart-pro-remove">
                                                            <form action="{{ route('cart.destroy', $cart_item->id) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger delete-cart-item"
                                                                    data-id="{{ $cart_item->id }}">Remove</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ec-cart-update-bottom"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <a href="{{ route('home') }}">Continue Shopping</a>
                                                <div style="display: flex; gap: 10px;">
                                                    {{-- <button type="submit" name="action" value="update"
                                                        class="btn btn-primary">Update Cart</button> --}}
                                                    <a href="#" class="btn btn-success">Go Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-cart-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary">
                                        <div>
                                            <span class="text-left">Sub-Total</span>
                                            <span class="text-right cart-subtotal">Rp 0</span>
                                        </div>
                                        <div>
                                            <span class="text-left">Delivery Charges & Taxes</span>
                                            <span class="text-right">Rp 10.000</span>
                                        </div>
                                        <div class="ec-cart-summary-total">
                                            <span class="text-left">Total Amount</span>
                                            <span class="text-right cart-total">Rp 0</span>
                                        </div>
                                    </div>
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
