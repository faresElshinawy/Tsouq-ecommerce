@extends('endUser.layouts.master')


@section('title', 'tsouq Sign')


@section('page title', 'Product Details')

@section('page', 'Product Details')

@section('content')

@section('css')
    <style>
        .product-description {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
    </style>


@endsection


@include('endUser.layouts.header')
<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border" style="min-height:500px; max-height: 500px">

                    <div class="carousel-item active">
                        <img class="w-100 h-100 img-fluid"
                            @if (filter_var($product->image, FILTER_VALIDATE_URL)) src="{{ $product->image }}"

                        @else

                        src="{{ asset('uploads/products/' . $product->image) }}" @endif
                            alt="Image">
                    </div>

                    @foreach ($product->images as $image)
                        <div class="carousel-item">
                            <img class="w-100 h-100 img-fluid"
                                @if (filter_var($image->image, FILTER_VALIDATE_URL)) src="{{ $productImage->image }}"

                            @else

                            src="{{ asset('uploads/products/' . $image->image) }}" @endif
                                alt="Image">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    @switch(round($product->rates->avg('rate')))
                        @case(1)
                            <small class="fas fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                        @break

                        @case(2)
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                        @break

                        @case(3)
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="far  fa-star"></small>
                            <small class="far fa-star"></small>
                        @break

                        @case(4)
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="far fa-star"></small>
                        @break

                        @case(5)
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                        @break

                        @default
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                            <small class="far fa-star"></small>
                        @break
                    @endswitch
                </div>
                <small class="pt-1">({{ $product->rates->count() }})</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4 inline-block">

                @if ($product->discount)
                    ${{ number_format($product->price - ($product->discount / 100) * $product->price) }} <del
                        class="text-muted  ml-2">${{ $product->price }}</del>
                @else
                    ${{ $product->price }}
                @endif

            </h3>
            <p class="mb-4">{{ $product->description }}</p>
            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                @foreach ($product->sizes as $size)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" {{ $loop->first == 1 ? 'checked' : null }}
                            id="size-{{ $size->id }}" value='{{ $size->id }}' name="size">
                        <label class="custom-control-label" for="size-{{ $size->id }}">{{ $size->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="d-flex mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                @foreach ($product->colors as $color)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-{{ $color->id }}"
                            {{ $loop->first == 1 ? 'checked' : null }} value='{{ $color->id }}' name="color">
                        <label class="custom-control-label"
                            for="color-{{ $color->id }}">{{ $color->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus" id="btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" name="quantity" id="quantity"
                        value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus" id="btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                @if ($product->count() > 0)
                    <button class="btn btn-primary px-3" id="add-to-cart-btn"><i class="fa fa-shopping-cart mr-1"></i>
                        Add To Cart</button>
                @endif
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-muted  ml-2" data-toggle="dropdown">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block"><i class='bx bx-list-plus'
                                    style="font-size: 30px"></i></span>
                        </button>
                        <div class="dropdown-menu rounded-0 m-0">
                            <span class="text-muted text-center ml-3">Add To WishList</span>
                            @if (Auth::user()->count() > 0)
                                @foreach (Auth::user()->wishlists as $wishlist)
                                    <button class="dropdown-item btn"
                                        onclick="addToWishlist({{ $wishlist->id }},{{ $product->id }})">{{ $wishlist->name }}</button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endauth
            </div>
            @if ($product->count() <= 0)
                <span class="text-muted h6">out of stock</span>
            @elseif($product->count() < 20)
                <span class="text-danger h6">In Stock Only {{ $product->count() }} Left - Order Soon</span>
            @endif
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex ">
                    {!! $shareButtons !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link " data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link active" data-toggle="tab" id="rates-button" href="#tab-pane-3">Reviews
                    ({{ $product->rates->count() }})</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade " id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p class="product-description">{{ $product->description }}</p>
                </div>
                <div class="tab-pane fade show active" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">{{ $product->rates->count() }} review for "Colorful Stylish Shirt"</h4>
                            <div id="rates-paginate-reslut" style="min-height: 650px">
                                @foreach ($product_rates as $rate)
                                    <div class="media mb-4" id="rate-{{ $rate->id }}-holder">
                                        <img src="{{ asset('uploads/users/' . $rate->user->image) }}" alt="Image"
                                            class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <div class="d-flex align-item-center">
                                                <h6 class="inline-block">{{ $rate->user->name }}</h6>
                                                @auth
                                                    @if (
                                                        $rate->user->id == auth()->user()->id ||
                                                            (auth()->user()->roles_name != null
                                                                ? auth()->user()->can('delete reviews')
                                                                : null))
                                                        <div class="inline-block">
                                                            <span><a type="button"
                                                                    onclick="deleteRate({{ $rate->id }})"
                                                                    class="text-danger text-sm btn btn-sm">delete</a></span>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                            <div class="text-primary mb-2">
                                                <span class="rating-stars">
                                                    @switch(round($rate->rate))
                                                        @case(1)
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                        @break

                                                        @case(2)
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                        @break

                                                        @case(3)
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far  fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                        @break

                                                        @case(4)
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                        @break

                                                        @case(5)
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                        @break

                                                        @default
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                            <small class="far fa-star"></small>
                                                        @break
                                                    @endswitch
                                                </span>
                                            </div>
                                            <p>{{ $rate->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-center" id="rates-paginate">
                                    {{ $product_rates->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>You Can Give Us Your Opinion Too. Required fields are marked *</small>
                            <div class="d-flex my-3 rating-container">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary rating-stars" id="rate_i">
                                    <i class="far fa-star" data-rating="1"></i>
                                    <i class="far fa-star" data-rating="2"></i>
                                    <i class="far fa-star" data-rating="3"></i>
                                    <i class="far fa-star" data-rating="4"></i>
                                    <i class="far fa-star" data-rating="5"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Your Review *</label>
                                <textarea id="message" cols="30" rows="5" name="comment" id="comment-area" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="rate"
                                    value="{{ old('rate') }}" hidden id="selectedRating">
                            </div>
                            <div class="form-group mb-0">
                                @auth
                                    <input type="submit" value="Leave Your Review" id="new-review-btn"
                                        class="btn btn-primary px-3">
                                @endauth
                                @guest
                                    <a href="{{ route('user-login.create') }}" class="btn btn-primary px-3">Leave
                                        Your Review</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">

                @foreach ($products as $pro)
                    <div class="card product-item border-0">
                        <div
                            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('uploads/products/' . $pro->image) }}"
                                alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $pro->name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>${{ number_format($pro->price - ($pro->discount / 100) * $product->price) }}
                                </h6>
                                <h6 class="text-muted  ml-2"><del>${{ $pro->price }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('products-details.show', ['product' => $pro->id]) }}"
                                class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                                Detail</a>
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
                @endforeach

            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@endsection


@section('js')
<script>
    $(document).ready(function() {

        // Handle rating selection
        $('.rating-container .rating-stars i').click(function() {
            var rating = $(this).data('rating');
            $('.rating-container .rating-stars i').removeClass('fas').addClass('far');
            $(this).prevAll().addBack().removeClass('far').addClass('fas');
            // Store the selected rating value in a hidden input field or perform further actions
            $('input[type="number"][name="rate"]').val(rating);
        });
    });


    $(document).ready(function() {
        $('#rates-button').click(function() {
            $.ajax({
                url: '{{ route('products-details.rates', ['product' => $product->id]) }}',
                type: 'post',
                datatype: 'html',
                cache: false,
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#rates-paginate-reslut').empty().html(data)
                }
            })
        })
    })


    $(document).ready(function() {

        $(document).on('click', '#rates-paginate a', function(e) {
            e.preventDefault()
            $.ajax({
                url: $(this).attr('href'),
                type: 'post',
                datatype: 'html',
                cache: false,
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#rates-paginate-reslut').empty().html(data)
                }
            })
        })

    })

    $('#add-to-cart-btn').click(function() {
        var size = $('input[name="size"][type="radio"]:checked').val();
        var color = $('input[name="color"][type="radio"]:checked').val();
        var quantity = $('input[name="quantity"][type="text"]').val();

        $.ajax({
            url: "{{ route('cart-item.store') }}",
            type: 'post',
            datatype: 'json',
            cache: false,
            data: {
                '_token': '{{ csrf_token() }}',
                'size': size,
                'color': color,
                'quantity': quantity,
                'product_id': '{{ $product->id }}'
            },
            success: function(data) {
                if (data.code == 400) {
                    var errors = [];
                    var html = '';
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) {
                            errors.push(data.errors[key]);
                        }
                    }
                    html = errors.join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'validation error',
                        html: html,
                        showConfirmButton: false
                    })
                } else if (data.code == 417) {
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false
                    })
                } else if (data.code == 416) {
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false
                    })
                } else if (data.code == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false
                    })
                    console.log(data.data);
                    $('#cart_count').empty().text(data.data);
                }
            }
        })
    });


    function deleteRate(rate_id) {
        $.ajax({
            url: '{{ route('new-product-rate.destroy') }}',
            type: 'post',
            datatype: 'json',
            cache: false,
            data: {
                '_token': '{{ csrf_token() }}',
                'rate_id': rate_id
            },
            success: function(data) {
                if (data.code == 400) {
                    var errors = [];
                    var html = '';
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) {
                            errors.push(data.errors[key]);
                        }
                    }
                    html = errors.join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'validation error',
                        html: html,
                        showConfirmButton: false
                    })
                } else if (data.code == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false
                    })
                    $(`#rate-${rate_id}-holder`).remove()
                }
            }
        })
    }
</script>

@auth
    <script>
        $('#new-review-btn').click(function() {
            var rate = $('input[name="rate"][type="number"]').val();
            var comment = $('textarea[name="comment"]').val();
            console.log(comment)
            $.ajax({
                url: '{{ route('new-product-rate.store') }}',
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'rate': rate,
                    'comment': comment,
                    'product_id': '{{ $product->id }}'
                },
                success: function(data) {
                    if (data.code == 400) {
                        var errors = [];
                        var html = '';
                        for (var key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                errors.push(data.errors[key]);
                            }
                        }
                        html = errors.join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'validation error',
                            html: html,
                            showConfirmButton: false
                        })
                    } else if (data.code == 200) {
                        var rating = Math.round(data.data.rate);
                        var starIcons = '';

                        switch (rating) {
                            case 1:
                                starIcons = '<small class="fas fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>';
                                break;

                            case 2:
                                starIcons = '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>';
                                break;

                            case 3:
                                starIcons = '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="far fa-star"></small>' +
                                    '<small class="far fa-star"></small>';
                                break;

                            case 4:
                                starIcons = '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="far fa-star"></small>';
                                break;

                            case 5:
                                starIcons = '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>' +
                                    '<small class="fas fa-star"></small>';
                                break;
                        }
                        var html = `
                <div class="media mb-4" id="rate-${data.data.id}-holder">
                                <img src="{{ asset('uploads/users') }}/${data.data.image}" alt="Image"
                                    class="img-fluid mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <div class="d-flex align-item-center">
                                        <h6 class="inline-block">{{ Auth::user()->name }}</h6>
                                                <div class="inline-block">
                                                    <span><a type="button" onclick="deleteRate(${data.data.id})"
                                                            class="text-danger text-sm btn btn-sm">delete</a></span>
                                                </div>
                                    </div>
                                    <div class="text-primary mb-2">
                                        <span class="rating-stars">
                                            ${starIcons}
                                        </span>
                                    </div>
                                    <p>${data.data.comment}</p>
                                </div>
                            </div>
                `;
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false
                        })
                        $('input[name="rate"][type="number"]').val('');
                        $('textarea[name="comment"]').val('');
                        $('.rating-container .rating-stars i').removeClass('fas').addClass('far');
                        $('#rates-paginate-reslut').prepend(html);
                    }
                }
            })
        });
    </script>
@endauth

<!-- Share JS -->
<script src="{{ asset('js/share.js') }}"></script>

@endsection
