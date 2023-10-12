    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">@yield('page title')</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('home.show')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">@yield('page')</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
