@if ($products->count() > 0)
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" style="min-height:280px; max-height: 280px"
                        @if(filter_var($product->image, FILTER_VALIDATE_URL))
                        src="{{ $product->image }}"
                        @else
                            src="{{ asset('uploads/products/' . $product->image) }}"
                        @endif
                        >
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
                        class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
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
                                        <form action="{{ route('wish-list-item.store', ['wishList' => $wishlist->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('post')
                                            <input type="text" hidden value="{{ $product->id }}" name="product_id">
                                            <button class="dropdown-item btn btn-block">{{ $wishlist->name }}</button>
                                        </form>
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

    {{-- <div class="col-12 pb-1">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-3" id="products-pagination">
                {{ $products->links('pagination::bootstrap-4') }}
            </ul>
        </nav>
    </div> --}}
@else
    <div class="col-12 d-flex justify-content-center mt-3">
        <p class="text-primary h5">No Products Found</p>
    </div>
@endif
