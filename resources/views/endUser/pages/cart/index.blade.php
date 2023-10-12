@extends('endUser.layouts.master')


@section('title','tsouq Cart')


@section('page title',Setting::get('cart-header'))

@section('page',Setting::get('cart-title'))

@section('content')
@include('endUser.layouts.header')

    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5" id="cart-items-table">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                            @if ($items)
                                @foreach ($items as $item)
                                    <tr id="cart-item-{{$item->id}}">
                                        <td class="align-middle"><img src="img/item-1.jpg" alt="" style="width: 50px;">{{$item->product->name}}</td>
                                        <td class="align-middle">${{number_format($item->product->price)}}</td>
                                        <td class="align-middle">

                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-minus"  onclick="updateCartItem({{$item->id}},{{$item->quantity}})">
                                                    <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm bg-secondary text-center"  value="{{$item->quantity}}" id="quantity-{{$item->id}}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-plus"  onclick="updateCartItem({{$item->id}},{{$item->quantity}})">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            {{-- <div class="text-muted" id="item-{{$item->id}}-updated"></div>   --}}
                                        </td>
                                        <td class="align-middle">{{ $item->color->name}}</td>
                                        <td class="align-middle">{{ $item->size->name}}</td>
                                        <td class="align-middle">{{ $item->product->discount }}%</td>
                                        <td class="align-middle">${{ number_format(($item->product->price - ($item->product->discount / 100) * $item->product->price) * $item->quantity) }}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-danger" onclick="deleteCartItem({{$item->id}},{{$item->product->price}},{{$item->quantity}},{{$item->product->discount}})"><i class="fa fa-times"></i></button>
                                            {{-- <button class="btn btn-sm btn-primary" onclick="updateCartItem({{$item->id}},{{$item->quantity}})"><i class='bx bxs-edit' ></i></button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium" >$<span id="cart-sub-total">{{  $subTotal  }}</span></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">${{Setting::get('tax')}}</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between text-dark mt-2">
                            <p class="font-weight-bold h5">Total</p>
                            <p class="font-weight-bold h5" >$<span id="cart-total">{{  $total  }}</span></p>
                        </div>
                        <div class="d-flex justify-content-end text-muted">
                            <del>$<span id="discount-total">{{$discount}}</span></del>
                        </div>
                        <a href="{{route('checkout.show',['order'=>$order_id])}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

@endsection


@section('js')
    <script>

        function deleteCartItem(itemId,price,count,discount){

            $.ajax({
                url:"{{route('cart-item.destroy')}}",
                type:'post',
                datatype:'html',
                cache:false,
                data:{"_token":"{{csrf_token()}}" , 'id':itemId},
                success:function(data){
                    if(data.code == 200){
                        var subTotal = $('#cart-sub-total').text();
                        var total = $('#cart-total').text();
                        var cartCount = $('#cart_count').text();
                        var tax = parseInt("{{Setting::get('tax')}}");
                        // response message
                        html = " <td colspan = '8' > <div class='d-flex justify-content-center'> <span class='text-danger'> "+data.message+" </span> <div></td>";
                        $('#cart-item-'+itemId).empty().html(html);
                        //calc sub total and total values after delete
                        $('#cart-sub-total').empty().text(parseInt(data.data.subTotal));
                        $('#cart-total').empty().text(parseInt(data.data.total));
                        $('#discount-total').empty().text(parseInt(data.data.discount));
                        $('#cart_count').empty().text(cartCount);
                        Swal.fire({
                            icon:'success',
                            title:data.message,
                            showConfirmButton:false
                        });

                    } else if(data.code == 404){
                        html = "<div class='alert alert-primary'>"+data.message+"</div>";
                        $('#cart-items-table').prepend(html);
                    } else if(data.code == 422){
                        html = "<div class='alert alert-danger'><ul>";
                            console.log(data)
                        if(Array.isArray(data.errors.id)){
                            data.errors.id.forEach(function(message){
                                html += "<li>"+message+"</li>";
                            });
                        }
                        html += "</ul></div>";
                        $('#cart-items-table').prepend(html);
                    }

                }
            })
        }


        function updateCartItem(item_id,nowQuantity) {
            $(document).ready(function (){
                var quantity = $(`#quantity-${item_id}`).val();
                $.ajax({
                    url: "{{ route('cart-item.update') }}",
                    type: 'post',
                    datatype: 'json',
                    cache: false,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'quantity': quantity,
                        'item_id': item_id
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
                                showConfirmButton:false
                            })
                            $(`#quantity-${item_id}`).val(nowQuantity);
                        }else if(data.code == 416){
                            Swal.fire({
                                icon:'error',
                                title:data.message,
                                showConfirmButton:false
                            })
                        }else if(data.code == 417){
                            Swal.fire({
                                icon:'error',
                                title:data.message,
                                showConfirmButton:false
                            })
                        }else if(data.code == 200){
                            Swal.fire({
                                icon:'success',
                                title:data.message,
                                showConfirmButton:false
                            })
                            // var html = 'saved.'
                            // $(`#item-${item_id}-updated`).empty().append(html);
                            $('#cart-sub-total').empty().text(parseInt(data.data.subTotal));
                            $('#cart-total').empty().text(parseInt(data.data.total));
                            $('#discount-total').empty().text(parseInt(data.data.discount));
                        }
                    }
                });
            })
        }
        


    </script>
@endsection
