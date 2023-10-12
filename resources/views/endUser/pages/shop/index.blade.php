@extends('endUser.layouts.master')


@section('title', 'tsouq Shop')


@section('page title', Setting::get('our-shop-header'))

@section('page', Setting::get('our-shop-title'))

@section('content')
    @include('endUser.layouts.header')

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input filter-selector " value='0' name='price'
                            checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <span class="badge border font-weight-normal">{{ $products->count }}</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" value='0-100' id="price-1">
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                        <span
                            class="badge border font-weight-normal">{{ \App\Models\Product::whereBetween('price', [0, 100])->count() }}</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" value='100-200' id="price-2">
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                        <span
                            class="badge border font-weight-normal">{{ \App\Models\Product::whereBetween('price', [100, 200])->count() }}</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name='price' value='200-300' id="price-3">
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                        <span
                            class="badge border font-weight-normal">{{ \App\Models\Product::whereBetween('price', [200, 300])->count() }}</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name='price' value='300-400' id="price-4">
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                        <span
                            class="badge border font-weight-normal">{{ \App\Models\Product::whereBetween('price', [300, 400])->count() }}</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="radio" class="custom-control-input" name='price' value='400-500' id="price-5">
                        <label class="custom-control-label" for="price-5">$400 - $500</label>
                        <span
                            class="badge border font-weight-normal">{{ \App\Models\Product::whereBetween('price', [400, 500])->count() }}</span>
                    </div>
                </div>
                <!-- Price End -->


                <!-- categories Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by category</h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input categories-selector" name="categories"
                            value='0' {{ !($category_filter ?? false) ? 'checked' : null }} id="categories-all">
                        <label class="custom-control-label" for="categories-all">All categories</label>
                        <span class="badge border font-weight-normal">{{ $categories->count() }}</span>
                    </div>

                    @foreach ($categories as $category)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input categories-selector"
                                {{ ($category_filter ?? false) && $category_filter == $category->id ? 'checked' : null }}
                                id="category-{{ $category->id }}" name='categories' value='{{ $category->id }}'>
                            <label class="custom-control-label"
                                for="category-{{ $category->id }}">{{ $category->name }}</label>
                            <span class="badge border font-weight-normal">{{ $category->products->count() }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- categories End -->



                <!-- brands Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by brand</h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input brands-selector" name="brands" value='0'
                            id="brands-all" {{ !($brand_filter ?? false) ? 'checked' : null }}>
                        <label class="custom-control-label" for="brands-all">All brands</label>
                        <span class="badge border font-weight-normal">{{ $brands->count() }}</span>
                    </div>

                    @foreach ($brands as $brand)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input brands-selector"
                                id="brand-{{ $brand->id }}" name='brands' value='{{ $brand->id }}'
                                {{ ($brand_filter ?? false) && $brand_filter == $brand->id ? 'checked' : null }}>
                            <label class="custom-control-label"
                                for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                            <span class="badge border font-weight-normal">{{ $brand->products->count() }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- brands End -->

                <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input colors-selector" name="colors"
                            value='0' checked id="color-all">
                        <label class="custom-control-label" for="color-all">All Color</label>
                        {{-- <span class="badge border font-weight-normal">{{ \App\Models\ProductColor::distinct('product_id')->count() }}</span> --}}
                        <span class="badge border font-weight-normal">{{ $colors->count() }}</span>
                    </div>

                    @foreach ($colors as $color)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input colors-selector"
                                id="color-{{ $color->id }}" name='colors' value='{{ $color->id }}'>
                            <label class="custom-control-label"
                                for="color-{{ $color->id }}">{{ $color->name }}</label>
                            <span class="badge border font-weight-normal">{{ $color->products->count() }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- Color End -->



                <!-- Size Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input sizes-selector" value='0' name="sizes"
                            checked id="size-all">
                        <label class="custom-control-label" for="size-all">All Size</label>
                        <span class="badge border font-weight-normal">{{ $sizes->count() }}</span>
                    </div>

                    @foreach ($sizes as $size)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="sizes" class="custom-control-input sizes-selector"
                                value="{{ $size->id }}" id="size-{{ $size->id }}">
                            <label class="custom-control-label"
                                for="size-{{ $size->id }}">{{ $size->name }}</label>
                            <span class="badge border font-weight-normal">{{ $size->products->count() }}</span>
                        </div>
                    @endforeach

                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">

                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="input-group ">
                                <input type="text" class="form-control col-3" placeholder="Search by name"
                                    name='query' id="search-query">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dropdown ml-4" id="filter-filters">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" type='button' value=''>No Filter</a>
                                    <a class="dropdown-item" type='button' value='created_at'>Latest</a>
                                    <a class="dropdown-item" type='button' value='solded_out'>Popularity</a>
                                    <a class="dropdown-item" type='button' value='Best Rating'>Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row  pb-3" id="filter-result">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100"
                                        @if (filter_var($product->image, FILTER_VALIDATE_URL)) src="{{ $product->image }}"

                                    @else

                                    src="{{ asset('uploads/products/' . $product->image) }}" @endif
                                        style="min-height:280px; max-height: 280px" alt="">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        @if ($product->discount != null)
                                            <h6>${{ number_format($product->price - ($product->discount / 100) * $product->price) }}
                                            </h6>
                                            <h6 class="text-muted  ml-2"><del>${{ $product->price }}</del></h6>
                                        @else
                                            <h6 class="text-muted  ml-2">${{ $product->price }}</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="{{ route('products-details.show', ['product' => $product->id]) }}"
                                        class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                                        Detail</a>
                                    <div>
                                        @auth
                                            <div class="dropdown">
                                                <a class="btn btn-sm text-dark p-0" data-toggle="dropdown">
                                                    <span class="d-none d-sm-block"><i
                                                            class='bx bx-list-plus text-primary mr-1'
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
                                            <a href="{{ route('user-login.create') }}" class="btn btn-sm text-dark p-0">
                                                <span class="d-none d-sm-block"><i class='bx bx-list-plus text-primary mr-1'
                                                        style="font-size: 25px"></i>More Options</span></a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    {{-- <div class="col-12 pb-1" id="products-pagination">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-3">
                                {{ $products->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>


        {{-- </div> --}}
    </div>
    <!-- Shop End -->


@endsection


@section('js')


    <script>

        let filter;

        $(document).on('click', "#filter-filters a", function(e) {

            $('#filter-filters a').removeClass('active');
            $(this).addClass('active')

            filter = $(this).attr('value')


            ajaxFilter()

        });


        $(document).on('click', "input[name='price']:radio", function(e) {

            ajaxFilter();

        })


        $(document).on('keyup', "#search-query", function(e) {

            ajaxFilter();

        })


        $(document).on('click', "input[type='checkbox']", function(e) {


            ajaxFilter();


        });



        function ajaxFilter() {
            var brands = getChecked('brands');
            var categories = getChecked('categories');
            var sizes = getChecked('sizes');
            var colors = getChecked('colors');
            var prices = getRadio('price');
            var query = $('#search-query').val()


            $.ajax({
                url: "{{ route('shop.show') }}",
                type: 'get',
                cache: false,
                datatype: 'html',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'brands': brands,
                    'categories': categories,
                    'colors': colors,
                    'sizes': sizes,
                    'prices': prices,
                    'query': query,
                    'filter': filter,
                },
                success: function(data) {
                    $('#filter-result').empty().html(data.data.view)
                    nextPage = data.data.nextPage;
                    $('#no-products-message').remove();
                }
            })
        }

        function getChecked(name) {

            values = []

            $('input[name=' + name + ']:checked').map(function() {
                values.push($(this).val())
            });

            return values;
        }

        function getRadio(name) {

            var value = $('input[type="radio"][name=' + name + ']:checked').attr('value')

            return value
        }
    </script>

    <script>
        function debounce(func, delay) {
            let time;
            return function() {
                clearTimeout(time);
                time = setTimeout(() => func.apply(), delay);
            }
        }


        let nextPage = "{{ $products->nextPageUrl() }}";
        let container = $('#filter-result');
        let loading;
        const debouncedLoadProducts = debounce(function() {
            if (nextPage != null && !loading) {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 800) {
                    loading = true;
                    var brands = getChecked('brands');
                    var categories = getChecked('categories');
                    var sizes = getChecked('sizes');
                    var colors = getChecked('colors');
                    var prices = getRadio('price');
                    var query = $('#search-query').val();

                    $.ajax({
                        url: nextPage, // Modify the URL based on your route
                        method: 'GET',
                        data: {
                            brands: brands,
                            categories: categories,
                            sizes: sizes,
                            colors: colors,
                            prices: prices,
                            query: query
                        },
                        success: function(data) {
                            container.append(data.data.view);
                            nextPage = data.data.nextPage;
                            loading = false;
                            if (nextPage == null) {
                                var html =
                                    '<span class="d-flex justify-content-center text-muted" id="no-products-message">No Products</span>'
                                container.after(html);
                            }
                        }

                    });
                }
            }
        }, 150);
        if (nextPage != null) {
            $(window).scroll(debouncedLoadProducts);
        }
    </script>



@endsection
