<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0 text-light">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse {{ request()->is('/') ? 'show' : null }} navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    @foreach (\App\Models\Category::get() as $category)
                        <a href="{{route('shop.category',['category'=>$category->id])}}" class="nav-item nav-link">{{$category->name}}</a>
                    @endforeach

                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{route('home.show')}}" class="nav-item nav-link {{ request()->is('/') ? 'active' : null }}">{{Setting::get('home-button')}}</a>
                        <a href="{{route('shop.show')}}" class="nav-item {{ request()->is('shop') ? 'active' : null }} nav-link">{{Setting::get('shop-button')}}</a>
                        @can('access dashboard')
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{Setting::get('control-panel-button')}}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                        <a href="{{route('statistics.all')}}" class="dropdown-item">dashboard</a>
                                    {{-- <a href="{{route('products.myProducts')}}" class="dropdown-item">My Products</a> --}}
                                </div>
                            </div>
                        @endcan
                        @auth
                            <a href="{{route('my-orders.all')}}" class="nav-item {{ request()->is('my-orders') ? 'active' : null }} nav-link">{{Setting::get('orders-button')}}</a>
                            <a href="{{route('customer-service.show')}}" class="nav-item {{ request()->is('customer-service') ? 'active' : null }} nav-link">Customer Service</a>
                        @endauth
                        <a href="{{route('contact.show')}}" class="nav-item {{ request()->is('contact') ? 'active' : null }} nav-link">{{Setting::get('contact-button')}}</a>
                    </div>
                    @guest
                        <div class="navbar-nav ml-auto py-0">
                            <a href="{{route('user-login.create')}}" class="nav-item {{ request()->is('login') ? 'active' : null }} nav-link">Login</a>
                            <a href="{{route('user-register.create')}}" class="nav-item {{ request()->is('register') ? 'active' : null }} nav-link">Register</a>
                        </div>
                    @endguest

                    @auth

                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{route('end-user.profile.edit')}}" class="nav-item {{ request()->is('profile') ? 'active' : null }} nav-link">{{Setting::get('profile-button')}}</a>
                        <a class="nav-item nav-link" type="button" onclick="$('#logout-form').submit()">Sign out</a>
                        <form action="{{route('user-login.destroy')}}" method="POST" id="logout-form">
                            @method('delete')
                            @csrf
                        </form>
                    </div>
                    @endauth
                </div>
            </nav>
            @yield('slider')
        </div>
    </div>
</div>
