@extends('layouts.frontend')

@section('content')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Cart</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Cart</li>
                            </ul>
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
                <div class="ec-cart-leftside col-lg-8 col-md-12">
                    <div class="ec-cart-content">
                        <div class="ec-cart-inner">
                            <div class="row">
                                <!-- Form UPDATE Cart -->
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
                                                                <input class="cart-plus-minus quantity" type="number" name="quantities[{{ $cart_item->id }}]"
                                                                    value="{{ $cart_item->quantity }}" min="1" />
                                                            </div>
                                                        </td>
                                                        <td class="ec-cart-pro-subtotal">
                                                            Rp <span
                                                                class="subtotal">{{ number_format($products[$cart_item->product_id]->price * $cart_item->quantity, 0, ',', '.') }}</span>
                                                        </td>
                                                        <td class="ec-cart-pro-remove">
                                                            <button type="button" class="btn btn-danger delete-cart-item"
                                                                data-id="{{ $cart_item->id }}">Remove</button>
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
                                                    <button type="submit" class="btn btn-primary">Update Cart</button>
                                                    <a href="{{url('/checkout')}}" class="btn btn-success">Go Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Form UPDATE Cart -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Area Start -->
                <div class="ec-cart-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary">
                                        <div class="ec-cart-summary-total">
                                            <span class="text-left">Total Amount</span>
                                            <span class="text-right cart-total">Rp <span id="total-amount">0</span></span>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateTotalAmount() {
                let total = 0;
                document.querySelectorAll(".subtotal").forEach(function(element) {
                    total += parseInt(element.textContent.replace(/\D/g, ""));
                });
                document.getElementById("total-amount").textContent = total.toLocaleString("id-ID");
            }

            document.querySelectorAll(".quantity").forEach(function(input) {
                input.addEventListener("input", function() {
                    let row = this.closest("tr");
                    let price = parseInt(row.querySelector(".product-price").value);
                    let quantity = parseInt(this.value);
                    let subtotalElement = row.querySelector(".subtotal");
                    subtotalElement.textContent = (price * quantity).toLocaleString("id-ID");
                    updateTotalAmount();
                });
            });

            updateTotalAmount();
        });
    </script>
@endsection
