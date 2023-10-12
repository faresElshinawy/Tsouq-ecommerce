<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5 d-flex justify-content-between">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">T</span>souq</h1>
            </a>
            <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{route('home.show')}}"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="{{route('shop.show')}}"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        @auth
                        <a class="text-dark mb-2" href="{{route('cart.show')}}"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        @endauth
                        @guest
                        <a class="text-dark mb-2" href="{{route('user-login.create')}}"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        @endguest
                        <a class="text-dark" href="{{route('contact.show')}}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{route('home.show')}}"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="{{route('shop.show')}}"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        @auth
                        <a class="text-dark mb-2" href="{{route('cart.show')}}"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        @endauth
                        @guest
                        <a class="text-dark mb-2" href="{{route('user-login.create')}}"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        @endguest
                        <a class="text-dark" href="{{route('contact.show')}}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">{{Setting::get('new-letter-title')}}</h5>
                    <form action="{{route('subscribe.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4 " name="name" placeholder="Your Name" />
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4" name="email" placeholder="Your Email"
                                />
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div>
                            <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4 ">
        <div class="col-12   px-xl-0  d-flex justify-content-center">
            <p class="mb-md-0 text-center text-md-left text-dark">
        <a class="text-dark font-weight-semi-bold " href="#">Tsouq</a>. All Rights Reserved. Developed
                by
                <a class="text-dark font-weight-semi-bold text-primary" href="https://htmlcodex.com">&copy; Fares El Shinawy</a><br>
            </p>
        </div>
    </div>
</div>
