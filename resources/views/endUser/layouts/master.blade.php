<!DOCTYPE html>
<html lang="en">

<head>
    @include('endUser.layouts.head')
    @yield('css')
</head>

<body>

    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: false
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Topbar Start -->
    @include('endUser.layouts.topbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('endUser.layouts.navbar')
    <!-- Navbar End -->



    @yield('content')



    <!-- Footer Start -->
    @include('endUser.layouts.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    {{-- <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a> --}}

    @include('endUser.layouts.js')

    @yield('js')
</body>

</html>
