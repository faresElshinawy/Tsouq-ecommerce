@extends('endUser.layouts.master')


@section('title', 'tsouq Checkout')


@section('page title', Setting::get('checkout-header'))

@section('page', Setting::get('checkout-title'))

@section('content')

    @include('endUser.layouts.header')

    @if (Session::has('voucher'))
        @php
            Session::forget('voucher');
        @endphp
    @endif

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">{{ Setting::get('Billing-address-title') }}</h4>
                    <div class="row">

                        <!-- addresses Start -->
                        <div class="border-bottom mb-4 pb-4 ml-3" id="addresses">

                            @foreach ($user_addresses as $address)
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" id="address{{$address->id}}-container">
                                    <input type="radio" class="custom-control-input filter-selector "
                                        id="address-check-{{ $address->id }}" value='0'
                                        onclick="selectedAddress({{ $address->id }})" name='address'
                                        {{ $loop->iteration == 1 ? 'checked' : null }} id="address-{{ $address->id }}">
                                    <label class="custom-control-label" for="address-check-{{ $address->id }}">
                                        {{ $address->country->name . ' , ' . ($address->city->name ?? $address->city_spare) . ' , ' . $address->street . ' , ' . $address->building_number }}</label>
                                    <a type="button" class="btn  btn-sm text-danger"
                                        onclick="deleteAddress({{$address->id}})"><i
                                            class='bx bx-trash'></i>delete</a>
                                </div>
                            @endforeach






                        </div>
                        <!-- addresses End -->


                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                    data-target="#shipping-address">Add New Address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <label class="font-weight-semi-bold mb-4">New Address</label>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" placeholder="123 456 789" name="phone">
                                <span class="text-danger" id="phone-message"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Street</label>
                                <input type="text" class="form-control" id="basic-default-street" name="street"
                                    placeholder="Street">
                                <span class="text-danger" id="street-message"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select name="country_id" id="basic-default-country" class="form-control">
                                    <option selected disabled>select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="country_id-message"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input type="text" class="form-control" id="basic-default-city_spare" name="city_spare"
                                    placeholder="City Name">
                                <span class="text-danger" id="city_spare-message"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="basic-defaul-building_number">Building number</label>
                                <input type="number" class="form-control" id="basic-default-building_number"
                                    name="building_number" placeholder="Building Number">
                                <span class="text-danger" id="building_number-message"></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="btn btn-primary mb-3 px-5 py-2"
                                    id="add-new-address-btn">Submit Address</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>

                        @foreach ($order->items as $item)
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p>{{ $item->product->name . ' --> ' . $item->quantity }}</p>
                                    <div class="d-flex justify-content-center">
                                        <h6>${{ number_format($item->product->price - ($item->product->discount / 100 * $item->product->price)) }}
                                        </h6>
                                        <h6 class="text-muted  ml-2"><del>${{ number_format($item->product->price) }}</del></h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">${{ $subTotal }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="total-price">${{ $total }}</h5>
                        </div>
                        <div id="discount_value">

                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Voucher Code" name="voucher">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="voucher-submit">Apply Voucher</button>
                        </div>
                    </div>
                    <div id="voucher-div" class="d-flex justify-content-between"></div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" checked
                                    id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div> --}}
                        {{-- <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <form action="{{ route('checkout.payment', ['order' => $order->id]) }}" method="post">
                            @csrf
                            <input type="text" name="address_id" id="address_id" hidden
                                value="{{ $first_address ? $first_address->id : null }}">
                            <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                                Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
@endsection



@section('js')
    <script>
        $('#voucher-submit').click(function() {
            var voucher = $('input[name="voucher"]').val();
            $.ajax({
                url: "{{ route('user-voucher.apply') }}",
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'voucher': voucher,
                    'order_id': '{{ $order->id }}'
                },
                success: function(response) {
                    if (response.code == 200) {
                        var html = "$" + response.data.new_price +
                            " <del class='font-weight-medium text-muted'>$" + response.data.total +
                            "</del>"
                        var discount =
                            '<div class="d-flex justify-content-between mt-2  mx-1"><p class="h6 text-muted">Discount</p><p class="h6 text-muted" >$' +
                            response.data.discount + '</p></div>'
                        var button =
                            '<div ><a type="button" class="btn btn-sm text-danger" onclick="voucherDelete()">Remove</a></div>';
                        $('#total-price').empty().html(html);
                        $('#total-div').empty().html(discount);
                        $('#discount_value').empty().html(discount);
                        $('#voucher-div').empty().text(response.message);
                        $('#voucher-div').addClass('text-muted');
                        $('#voucher-div').append(button);
                    } else if (response.code == 404) {
                        $('#voucher-div').addClass('text-danger');
                        $('#voucher-div').empty().text(response.message);
                    } else if (response.code == 400) {
                        $('#voucher-div').addClass('text-danger');
                        $('#voucher-div').empty().text(response.message);
                    }
                }
            })
        })





        function selectedAddress(address) {
            $('input[name="address_id"][type="text"]').val(address);
            address = $('input[name="address_id"][type="text"]').val();
        }



        function voucherDelete() {
            var voucher = $('input[name="voucher"]').val();
            $.ajax({
                url: "{{ route('user-voucher.destroy') }}",
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'voucher': voucher,
                    'order_id': '{{ $order->id }}'
                },
                success: function(response) {
                    if (response.code == 200) {
                        var html = "$" + response.data.total;
                        $('#total-price').empty().html(html);
                        $('#total-div').empty();
                        $('#discount_value').empty();
                        $('#voucher-div').empty().text(response.message);
                        $('#voucher-div').addClass('text-muted');
                        $('input[name="voucher"]').html('');
                    } else if (response.code == 400) {
                        $('#voucher-div').empty().text(response.message);
                        $('#voucher-div').addClass('text-muted');
                    }
                }
            })
        }


        $('#add-new-address-btn').click(function() {
            var street = $('input[name="street"][type="text"]').val();
            var phone = $('input[name="phone"][type="text"]').val();
            var city_spare = $('input[name="city_spare"][type="text"]').val();
            var country_id = $('select[name="country_id"]').val();
            var building_number = $('input[name="building_number"][type="number"]').val();
            $.ajax({
                url: '{{ route('user-address.store') }}',
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'street': street,
                    'phone': phone,
                    'city_spare': city_spare,
                    'country_id': country_id,
                    'building_number': building_number
                },
                success: function(data) {
                    if (data.code == 400) {
                        var errors = [];
                        var html = '';
                        for (var key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                $(`input[name=${key}`).addClass('border-danger');
                                $(`select[name=${key}`).addClass('border-danger');
                                $(`#${key}-message`).empty().html(
                                    `<span class="text-danger">${data.errors[key]}</span>`);
                            }
                        }
                    } else if (data.code == 200) {
                        var html = `
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" id="address${data.data.id}-container">
                                    <input type="radio" class="custom-control-input filter-selector " id="address-check-${data.data.id}" value='0' onclick="selectedAddress(${data.data.id})"
                                        name='address' checked  id="address-${data.data.id}">
                                    <label class="custom-control-label" for="address-check-${data.data.id}">
                                        ${data.data.country.name} , ${data.data.city_spare} , ${data.data.street} , ${data.data.building_number}</label>
                                    <a type="button" class="btn  btn-sm text-danger"
                                        onclick="deleteAddress(${data.data.id})"><i
                                            class='bx bx-trash'></i>delete</a>
                                </div>
                    `;
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false
                        })
                        $('#addresses').prepend(html);
                        $('#shipping-address').removeClass('show');
                        $('input[name="street"][type="text"]').val('');
                        $('input[name="phone"][type="text"]').val('');
                        $('input[name="city_spare"][type="text"]').val('');
                        $('select[name="country_id"]').val('');
                        $('input[name="building_number"][type="number"]').val('');
                        selectedAddress(data.data.id);
                    }
                }
            })
        })


        function deleteAddress(address_id){
            $.ajax({
                url:"{{route('user-address.destroy')}}",
                type:'post',
                datatype:'json',
                cache:false,
                data:{'_token':"{{csrf_token()}}" , 'address_id':address_id},
                success:function (data){
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
                            icon: 'success',
                            title: data.message,
                            html:html,
                            showConfirmButton: false
                        })
                    } else if (data.code == 200) {
                        $(`#address${address_id}-container`).remove();
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false
                        })
                    }
                }
            })
        }






        // $('#basic-default-country').on('change',function(){
        //     country_id = $(this).val();
        //     $.ajax({
        //         url:"{{ route('user-address.cities') }}",
        //         type:'post',
        //         datatyp:'html',
        //         cache:false,
        //         data:{'_token':"{{ csrf_token() }}" , 'id':country_id},
        //         success:function(data){
        //             $('#basic-default-city').empty().html(data);
        //         }
        //     });
        // })
    </script>
@endsection
