    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('endUserAssets') }}/libs/easing/easing.min.js"></script>
    <script src="{{ asset('endUserAssets') }}/lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Contact Javascript File -->
    <script src="{{ asset('endUserAssets') }}/mail/jqBootstrapValidation.min.js"></script>
    <script src="{{ asset('endUserAssets') }}/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('endUserAssets') }}/js/main.js"></script>



    {{-- dashbarod js --}}

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/js/main.js"></script>
    <script src="{{ asset('endUserAssets/js/chat.js') }}"></script>
    {{-- @include('sweetalert::alert') --}}

    {{-- add to wishlist function --}}

    @auth
        @if (Route::currentRouteNamed('shop.*') ||
                Route::currentRouteNamed('products-details.show') ||
                Route::currentRouteNamed('home.show'))
            <script>
                function addToWishlist(wishlist_id, product_id) {
                    $(document).ready(function() {
                        $.ajax({
                            url: "{{ route('wish-list-item.store') }}",
                            type: 'post',
                            datatype: 'json',
                            cache: false,
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'wishlist_id': wishlist_id,
                                'product_id': product_id
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
                                } else if (data.code == 406) {
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
                                    $('#wishlist-items-count').empty().text(data.data.wishlist_items_count);
                                }
                            }
                        })
                    })
                }
            </script>
        @endif
    @endauth

    <script>
                function newSubscriber(){
                    name = $('#subscriber_name').val() ?? null;
                    email = $('#subscriber_email').val();
                    $.ajax({
                        url:"{{route('subscribe.store')}}",
                        type:'post',
                        datatype:'json',
                        cache:false,
                        data:{'_token':"{{csrf_token()}}" , 'name':name , 'email':email},
                        success:function (data){
                            if(data.code == 400){
                                errors = [];
                                for(key in data.errors){
                                    if(data.errors.hasOwnProperty(key)){
                                        errors.push(data.errors[key]);
                                    }
                                }
                                errors.join('\n');
                                Swal.fire({
                                    icon:'error',
                                    title:data.message,
                                    html:errors,
                                    showConfirmButton:false
                                });
                            }else if(data.code == 200){
                                Swal.fire({
                                    icon:'success',
                                    title:data.message,
                                    showConfirmButton:false
                                });
                                $('#subscriber_name').val('');
                                $('#subscriber_email').val('')
                            }
                        }
                    });
                }
    </script>
