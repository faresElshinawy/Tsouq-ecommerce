@if ($items->count() > 0)
    {{-- <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="input-group ">
                    <input type="text" class="form-control col" placeholder="Search by name" name='query'
                        id="search-query">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row  pb-3" id="wishlist{{ $wishlist_id }}-items-div">
        @foreach ($items as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1" id="wish-list-item-{{$item->id}}">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('uploads/products/' . $item->product->image) }}"
                            alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $item->product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>${{ number_format($item->product->price - ($item->product->discount / 100) * $item->product->price) }}
                            </h6>
                            <h6 class="text-muted  ml-2"><del>${{ $item->product->price }}</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products-details.show', ['product' => $item->product->id]) }}"
                            class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <div>
                                <a type="button" class="btn btn-sm text-dark p-0" id="wishlist-item-delete" onclick='deleteWishListItem({{$item->id}},{{$item->wish_list_id}})'><i class='bx bxs-message-alt-x text-primary mr-1'></i>Remove</a>
                                {{-- <a class="btn btn-sm text-dark p-0" id="wishlist-delete" onclick='$("#delete-wishllis-{{$item->id}}").submit()'><i class='bx bxs-message-alt-x text-primary mr-1'></i>Remove</a> --}}
                                {{-- <form action="{{route('wish-list-item.destroy',['wishlist_item'=>$item->id])}}" id="delete-wishllis-{{$item->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form> --}}
                            </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="col-12 d-flex justify-content-center mt-3">
        <p class="text-primary h5">No Products Found</p>
    </div>


@endif
