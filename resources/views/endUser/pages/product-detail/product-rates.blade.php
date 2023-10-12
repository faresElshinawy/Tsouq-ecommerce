@if ($product_rates->count() > 0)

    @foreach ($product_rates as $rate)
    <div class="media mb-4">
        <img src="{{ asset('uploads/users/' . $rate->user->image) }}" alt="Image"
            class="img-fluid mr-3 mt-1" style="width: 45px;">
        <div class="media-body">
            <div class="d-flex align-item-center">
                <h6 class="inline-block">{{ $rate->user->name }}</h6>
                @auth
                    @if (
                        $rate->user->id == auth()->user()->id ||
                            (auth()->user()->roles_name != null ? in_array('owner', auth()->user()->roles_name) : false))
                        <div class="inline-block">
                            <span><a type="button" onclick="$('#rate-delete').submit()"
                                    class="text-danger text-sm btn btn-sm">delete</a></span>
                            <form
                                action="{{ route('new-product-rate.destroy', ['rate' => $rate->id]) }}"
                                id="rate-delete" method="post">
                                @csrf
                                @method('delete')
                            </form>
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
                    @endswitch
                </span>
            </div>
            <p>{{ $rate->comment }}</p>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center" id="rates-paginate">
    {{$product_rates->links('pagination::bootstrap-4')}}
    </div>

@else

<div class="d-flex justify-content-center">
    <p class="text-priamry">no rates yet</p>
</div>

@endif
