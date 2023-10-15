@extends('endUser.layouts.master')


@section('title', 'tsouq')

@section('slider')
    <div id="header-carousel" class="carousel slide" data-ride="carousel">

        @if (Setting::get('slider-type') == 'static')
            <div class="carousel-inner">

                <div class="carousel-item active" style="height: 410px;">
                    <img class="img-fluid" src="{{ asset('uploads/settings/' . Setting::get('slider-one-image')) }}"
                        alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-3">
                                {{ Setting::get('slider-one-sub-title') }}</h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                {{ Setting::get('slider-one-title') }}</h3>
                            <a href="{{ Setting::get('slider-one-url') }}" class="btn btn-light py-2 px-3">Shop Now</a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item " style="height: 410px;">
                    <img class="img-fluid" src="{{ asset('uploads/settings/' . Setting::get('slider-two-image')) }}"
                        alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-3">
                                {{ Setting::get('slider-two-sub-title') }}</h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                {{ Setting::get('slider-two-title') }}</h3>
                            <a href="{{ Setting::get('slider-two-url') }}" class="btn btn-light py-2 px-3">Shop Now</a>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="carousel-inner">
                @foreach ($brands as $brand)
                    <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : null }}" style="height: 410px;">
                        <img class="img-fluid"
                            @if (filter_var($brand->image, FILTER_VALIDATE_URL)) src="{{ $brand->image }}"

                            @else

                            src="{{ asset('uploads/brands/' . $brand->image) }}" @endif
                            alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                {{-- <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4> --}}
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">{{ $brand->name }}</h3>
                                <a href="{{ route('shop.brand', ['brand' => $brand->id]) }}"
                                    class="btn btn-light py-2 px-3">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
@endsection

@section('content')

    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">

            @foreach ($categories as $category)
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <p class="text-right">{{ $category->products->count() }} Products</p>
                        <a href="{{ Route('shop.category', ['category' => $category->id]) }}"
                            class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid" style="min-height:500px; max-height: 400px"
                                @if (filter_var($category->image, FILTER_VALIDATE_URL)) src="{{ $category->image }}"

                            @else

                            src="{{ asset('uploads/categories/' . $category->image) }}" @endif
                                alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">{{ $category->name }}</h5>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">

            @foreach ($brands as $brand)
                <div class="col-md-6 pb-4">
                    <div
                        class="position-relative bg-secondary text-center {{ $loop->iteration % 2 == 0 ? 'text-md-left ' : 'text-md-right' }} text-white mb-2 py-5 px-5">
                        {{-- <img src="{{asset('uploads/brands/' . $brand->image)}}" alt=""> --}}
                        <div class="position-relative" style="z-index: 1;">
                            <h1 class="mb-4 font-weight-semi-bold">{{ $brand->name }}</h1>
                            <a href="{{ route('shop.brand', ['brand' => $brand->id]) }}"
                                class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Top Selling Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">

            @foreach ($top_selling as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100"
                                @if (filter_var($product->image, FILTER_VALIDATE_URL)) src="{{ $product->image }}"

                                    @else

                                    src="{{ asset('uploads/products/' . $product->image) }}" @endif
                                alt="" style="min-height:280px; max-height: 280px">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>${{ number_format($product->price - ($product->discount / 100) * $product->price) }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>${{ number_format($product->price) }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i
                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <div>
                                @auth
                                    <div class="dropdown">
                                        <a class="btn btn-sm text-dark p-0" data-toggle="dropdown">
                                            <span class="d-none d-sm-block"><i class='bx bx-list-plus text-primary mr-1'
                                                    style="font-size: 25px"></i>More Options</span>
                                        </a>
                                        <div class="dropdown-menu rounded-0 m-0">
                                            <span class="text-muted text-center ml-3">Add To WishList</span>

                                            @foreach (Auth::user()->wishlists as $wishlist)
                                                <button class="dropdown-item btn btn-block"
                                                    onclick="addToWishlist({{ $wishlist->id }},{{ $product->id }})">{{ $wishlist->name }}</button>
                                            @endforeach

                                        </div>
                                    </div>
                                @endauth
                                @guest
                                    <a href="{{ route('user-login.create') }}" class="btn btn-sm text-dark p-0"> <span
                                            class="d-none d-sm-block"><i class='bx bx-list-plus text-primary mr-1'
                                                style="font-size: 25px"></i>More Options</span></a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span
                            class="bg-secondary px-2">{{ Setting::get('subscribe-title') }}</span></h2>
                    <p>{{ Setting::get('subscribe-description') }}</p>
                </div>

                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" name="email"
                            value='{{ old('email') }}' placeholder="Email Goes Here" id="subscriber_email">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4" onclick="newSubscriber()">Subscribe</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">


            @foreach ($just_arrived as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100"
                                @if (filter_var($product->image, FILTER_VALIDATE_URL)) src="{{ $product->image }}"

                            @else

                            src="{{ asset('uploads/products/' . $product->image) }}" @endif
                                alt="" style="min-height:280px; max-height: 280px">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>${{ number_format($product->price - ($product->discount / 100) * $product->price) }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>${{ number_format($product->price) }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i
                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <div>
                                @auth
                                    <div class="dropdown">
                                        <a class="btn btn-sm text-dark p-0" data-toggle="dropdown">
                                            <span class="d-none d-sm-block"><i class='bx bx-list-plus text-primary mr-1'
                                                    style="font-size: 25px"></i>More Options</span>
                                        </a>
                                        <div class="dropdown-menu rounded-0 m-0">
                                            <span class="text-muted text-center ml-3">Add To WishList</span>

                                            @foreach (Auth::user()->wishlists as $wishlist)
                                                <button class="dropdown-item btn btn-block"
                                                    onclick="addToWishlist({{ $wishlist->id }},{{ $product->id }})">{{ $wishlist->name }}</button>
                                            @endforeach

                                        </div>
                                    </div>
                                @endauth
                                @guest
                                    <a href="{{ route('user-login.create') }}" class="btn btn-sm text-dark p-0"> <span
                                            class="d-none d-sm-block"><i class='bx bx-list-plus text-primary mr-1'
                                                style="font-size: 25px"></i>More Options</span></a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    <!-- Products End -->


    {{-- <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-1.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-2.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-3.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-4.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-5.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-6.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-7.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{asset('endUserAssets')}}/img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End --> --}}

@endsection
