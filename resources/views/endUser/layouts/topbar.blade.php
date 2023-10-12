<div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="{{Setting::get('facebook')}}">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="{{Setting::get('twitter')}}">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="{{Setting::get('linked-in')}}">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="{{Setting::get('instagram')}}">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">T</span>souq</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="{{route('shop.search')}}">
                <div class="input-group">
                    <input type="text" class="form-control" name="query"  placeholder="Search for products">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        @auth
            <div class="col-lg-3 col-6 text-right">
                <a href="{{route('user-wishlists.all',['user'=>auth()->user()->id])}}" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge" id="wishlist-items-count" >
                        {{ Auth::user()->wishListsItems() }}
                    </span>
                </a>
                <a href="{{route('cart.show')}}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge" id="cart_count">{{ \App\Traits\CartExtra::getUserOrderId(auth()->user()->id)->items->count() }}</span>
                </a>
            </div>
        @endauth
    </div>
</div>
