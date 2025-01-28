<header class="ec-header">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col text-left header-top-left d-none d-lg-block">
                    <div class="header-top-social">
                        <ul class="mb-0">
                            <li class="list-inline-item"><a class="hdr-facebook" href="#"><i class="ecicon eci-facebook"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-twitter" href="#"><i class="ecicon eci-twitter"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-instagram" href="#"><i class="ecicon eci-instagram"></i></a></li>
                            <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i class="ecicon eci-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col text-center header-top-center">
                    <div class="header-top-message text-upper">
                        <span>Free Shipping</span> This Week Order Over - $75
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="ec-flex">
                    <div class="align-self-center">
                        <div class="header-logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="Site Logo" />
                                <img class="dark-logo" src="{{ asset('frontend/assets/images/logo/dark-logo.png') }}" alt="Site Logo" style="display: none;" />
                            </a>
                        </div>
                    </div>

                    <div class="align-self-center">
                        <div class="header-search">
                            <form class="ec-btn-group-form" action="#">
                                <input class="form-control ec-search-bar" placeholder="Search products..." type="text" />
                                <button class="submit" type="submit">
                                    <img src="{{ asset('frontend/assets/images/icons/search.svg') }}" class="svg_img header_svg" alt="" />
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="align-self-center">
                        <div class="ec-header-bottons">
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                                    <img src="{{ asset('frontend/assets/images/icons/user.svg') }}" class="svg_img header_svg" alt="User" />
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @guest
                                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                        @if (Route::has('register'))
                                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                        @endif
                                    @endguest
                                    @auth
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    @endauth
                                </ul>
                            </div>

                            <a href="wishlist.html" class="ec-header-btn ec-header-wishlist">
                                <div class="header-icon">
                                    <img src="{{ asset('frontend/assets/images/icons/wishlist.svg') }}" class="svg_img header_svg" alt="Wishlist" />
                                </div>
                                <span class="ec-header-count">4</span>
                            </a>

                            <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                <div class="header-icon">
                                    <img src="{{ asset('frontend/assets/images/icons/cart.svg') }}" class="svg_img header_svg" alt="Cart" />
                                </div>
                                <span class="ec-header-count cart-count-lable">3</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
