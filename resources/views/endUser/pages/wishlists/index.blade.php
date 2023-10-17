@extends('endUser.layouts.master')


@section('title', 'tsouq Wish Lists')


@section('page title', Setting::get('wishlists-header'))

@section('page', Setting::get('wishlists-title'))



@section('content')
    @include('endUser.layouts.header')

    <!-- wishlists Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Wish list Start -->
                <div class="border-bottom mb-4 pb-4">
                    <div class="d-flex justify-content-between align-item-center">
                        <h5 class="font-weight-semi-bold mb-4">Wish Lists ({{ $wishlists->count() }})</h5>
                        <a type='button' id="wishlist-create" class="btn btn-sm text-muted"><i class='bx bx-add-to-queue'></i>
                            Create New</a>
                    </div>
                    <div id="wishlist-container">
                        @if ($wishlists->count() > 0)
                            @foreach ($wishlists as $wishlist)
                                <div
                                    class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" id="wishlist-{{$wishlist->id}}-div">
                                    <input type="radio" class="custom-control-input filter-selector "
                                        value='{{ $wishlist->id }}' name='wishlist' id="wishlist-all-{{ $wishlist->id }}">
                                    <label class="custom-control-label"
                                        for="wishlist-all-{{ $wishlist->id }}">{{ $wishlist->name }}</label>
                                    <div class="align-item-center">
                                        <span class="badge border font-weight-normal"
                                            id="single-wishlist-count-{{ $wishlist->id }}">{{ \App\Models\WishListItem::where('wish_list_id', $wishlist->id)->count() }}</span>



                                        <a type="button" onclick="wishlistEdit({{ $wishlist->id }})"
                                            class="btn btn-sm text-muted"><i class='bx bxs-edit'></i> Edit</a>
                                        <button type='button' class="btn btn-sm text-danger"
                                            onclick='deleteWishlist({{$wishlist->id}})'>
                                            <i class='bx bx-trash'></i>
                                            remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="custom-control mb-3 ">
                                <span class="text-muted">{{ Setting::get('no-wishlists-holder') }}</span>
                            </div>
                        @endif
                    </div>


                </div>
                <!-- Wish list End -->


            </div>
            <!-- wishlist Sidebar End -->






            <!-- wishlist Product Start -->
            <div class="col-lg-9 col-md-12" id="wishlist-content">

                @if ($wishlists->count() > 0)
                    <p class="text-center text-muted mt-5">Choose Wishlist To Show Items</p>
                @else
                    <p class="text-center text-muted mt-5">{{ Setting::get('no-wishlists-message') }}</p>
                @endif

            </div>
        </div>


        {{-- </div> --}}
    </div>
    <!-- wishlists End -->


@endsection


@section('js')


    <script>
        function wishlistEdit(id) {
            var wishlist = id;
            $.ajax({
                url: "{{ route('user-wishlists.edit') }}",
                datatype: 'html',
                type: 'get',
                cache: false,
                data: {
                    'id': wishlist
                },
                success: function(data) {
                    var html = `
                    <div class="col-xxl">
                        <div class="card mb-4">
                        <div class="card-header bg-primary d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-light">Edit wishlist</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                                <div class="col-sm-10">
                                <input type="text" value='${data.data.name}' class="form-control " id="basic-default-name" name="name" placeholder="Name">
                                </div>
                            </div>





                            <div class="row justify-content-end">
                                <div class="col-sm-10 d-flex justify-content-between">
                                    <a type="submit" class="btn btn-primary" id="update-wishlist-btn" value="${data.data.id}">Update</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    `;
                    $('#wishlist-content').empty().append(html);
                }
            })
        }


        $('#wishlist-create').on('click', function() {
            html = `
                <div class="col-xxl">
                <div class="card mb-4">
                <div class="card-header bg-primary d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-light">New wishlist</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" id="basic-default-name" name="name" placeholder="Name">
                        </div>
                            <span class="text-danger" id="wishlist-name"></span>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-between">
                            <a type="submit" class="btn btn-primary" id="submit-create-new-wishlist">Create</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        `;
            $('#wishlist-content').empty().html(html);
        })

        $(document).on('click', '#submit-create-new-wishlist', function() {
            var name = $('input[name="name"]').val();
            $.ajax({
                url: "{{ route('user-wishlists.store') }}",
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name': name
                },
                success: function(data) {
                    if (data.code == 400) {
                        var errors = [];
                        var html = '';
                        console.log(errors)
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
                        html = `
                    <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" id="wishlist-${data.data.id}-div">
                                <input type="radio" class="custom-control-input filter-selector "
                                    value='${data.data.id}' name='wishlist' id="wishlist-all-${data.data.id}">
                                <label class="custom-control-label"
                                    for="wishlist-all-${data.data.id}">${data.data.name}</label>
                                <div class="align-item-center">
                                    <span class="badge border font-weight-normal"
                                        id="single-wishlist-count-${data.data.id}">0</span>



                                    <a type="button"
                                        onclick="wishlistEdit(${data.data.id})" class="btn btn-sm text-muted"><i
                                            class='bx bxs-edit'></i> Edit</a>
                                    <button type='button' class="btn btn-sm text-danger"
                                        onclick='deleteWishlist(${data.data.id})'>
                                        <i class='bx bx-trash'></i>
                                        remove</button>

                                </div>
                            </div>

                    `;
                        var message =
                            `<p class="text-center text-muted mt-5">Choose Wishlist To Show Items</p>`;
                            console.log("{{$wishlists->count()}}")
                        if("{{$wishlists->count() ? false:true}}"){
                            $('#wishlist-container').html('');
                        }
                        $('#wishlist-container').append(html);
                        $('input[name="name"]').val('');
                        $('#wishlist-content').empty().html(message);

                    }
                }
            })
        });


        $(document).on('click', '#update-wishlist-btn', function() {
            var name = $('input[name="name"]').val();
            var wishlist_id = $(this).attr('value');
            $.ajax({
                url: "{{ route('user-wishlists.update') }}",
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name': name,
                    'wishlist_id':wishlist_id
                },
                success: function(data) {
                    if (data.code == 400) {
                        var errors = [];
                        var html = '';
                        console.log(errors)
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
                        html = `
                                <input type="radio" class="custom-control-input filter-selector "
                                    value='${data.data.id}' name='wishlist' id="wishlist-all-${data.data.id}">
                                <label class="custom-control-label"
                                    for="wishlist-all-${data.data.id}">${data.data.name}</label>
                                <div class="align-item-center">
                                    <span class="badge border font-weight-normal"
                                        id="single-wishlist-count-${data.data.id}">${data.data.count}</span>



                                    <a type="button"
                                        onclick="wishlistEdit(${data.data.id})" class="btn btn-sm text-muted"><i
                                            class='bx bxs-edit'></i> Edit</a>
                                    <button type='button' class="btn btn-sm text-danger"
                                        onclick='deleteWishlist(${data.data.id})'>
                                        <i class='bx bx-trash'></i>
                                        remove</button>

                                </div>

                    `;
                        var message =
                            `<p class="text-center text-muted mt-5">Choose Wishlist To Show Items</p>`;
                        $(`#wishlist-${data.data.id}-div`).empty().append(html);
                        $('#wishlist-content').empty().html(message);

                    }
                }
            })
        });



        $(document).on('click', "input[type='radio'][name='wishlist']:radio", function(e) {
            var query = $('#search-query').val();
            var wishlist = getRadio('wishlist');

            $.ajax({
                url: "{{ route('wish-list-item.all') }}",
                type: 'post',
                datatype: 'html',
                cache: false,
                data: {
                    'query': query,
                    '_token': "{{ csrf_token() }}",
                    'wishlist': wishlist
                },
                success: function(data) {
                    $('#wishlist-content').empty().html(data);
                }
            })

        })


        $(document).on('keyup', "#search-query", function(e) {

            var query = $('#search-query').val();
            var wishlist = getRadio('wishlist');

            $.ajax({
                url: "{{ route('wish-list-item.all') }}",
                type: 'post',
                datatype: 'html',
                cache: false,
                data: {
                    'query': query,
                    '_token': "{{ csrf_token() }}",
                    'wishlist': wishlist
                },
                success: function(data) {
                    $('#wishlist-content').empty().html(data);
                }
            })

        })




        function deleteWishListItem(wishlistitem,wishlist) {
            $.ajax({
                url: "{{ route('wish-list-item.destroy') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": wishlistitem
                },
                success: function(data) {
                    if (data.code == 200) {
                        html =
                            "<div class='card product-item border-0 mb-4'><div class='card-body border-left border-right text-center p-0 pt-4 pb-3'><div class='d-flex justify-content-center h4 mt-1'><span class='mt-5 text-danger p-2'>" +
                            data.message + "</span></div></div></div>";
                            Swal.fire({
                                icon:'success',
                                title:data.message,
                                showConfirmButton:false
                            });
                        $('#wish-list-item-' + wishlistitem).empty().html(html);

                        var wish_List_Item_Count = parseInt($('#wishlist-items-count').text());
                        wish_List_Item_Count = wish_List_Item_Count > 0 ? wish_List_Item_Count - 1 : 0;
                        $('#wishlist-items-count').text(wish_List_Item_Count);

                        var wishlistCount = parseInt($('#single-wishlist-count-' + wishlist).text());
                        wishlistCount = wishlistCount > 0 ? wishlistCount - 1 : 0;
                        $('#single-wishlist-count-' + wishlist).text(wishlistCount);

                    } else if (data.code == 404) {
                        html = "<div class='alert alert-primary'>" + data.message + "</div>";
                        $('#wishlist-content').prepend(html);
                    } else if (data.code == 422) {
                        html = "<div class='alert alert-primary'><ul>";
                        console.log(data)
                        if (Array.isArray(data.errors.id)) {
                            data.errors.id.forEach(function(message) {
                                html += "<li>" + message + "</li>";
                            });
                        }
                        html += "</ul></div>";
                        $('#wishlist-content').prepend(html);
                    }
                }
            });
        }


        function deleteWishlist(wishlist_id){
            $(document).ready(function (){
                $.ajax({
                    url:"{{route('user-wishlists.destroy')}}",
                    type:"post",
                    datatype:"json",
                    cache:false,
                    data:{'_token':"{{csrf_token()}}" , 'wishlist_id':wishlist_id},
                    success:function (data){
                        if (data.code == 400) {
                            var errors = [];
                            var html = '';
                            console.log(errors)
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
                        } else if (data.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false
                            });
                            var deleteMessage =`<p class="text-center text-muted mt-5">${data.message}</p>`;
                            var message = `<p class="text-center text-muted mt-5">Choose Wishlist To Show Items</p>`;
                            $(`#wishlist-${wishlist_id}-div`).empty().html('');
                            $('#wishlist-content').html(message);
                            $(`#wishlist${wishlist_id}-items-div`).remove();
                            $('#wishlist-items-count').empty().text(data.data.wishlists_items_count);
                            if(!data.data.wishlists_count){
                                var html = `
                                <div class="custom-control mb-3 ">
                                    <span class="text-muted">{{ Setting::get('no-wishlists-holder') }}</span>
                                </div>
                                `;
                                $('#wishlist-container').html(html);
                            }
                        }
                    }
                })
            });
        }


        function getRadio(name) {

            var value = $('input[type="radio"][name=' + name + ']:checked').attr('value')

            return value
        }
    </script>




@endsection
