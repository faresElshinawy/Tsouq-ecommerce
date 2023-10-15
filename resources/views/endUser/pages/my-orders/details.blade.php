@extends('endUser.layouts.master')


@section('title','tsouq orders details')


@section('page title','Orders Details')

@section('page','Orders Details')

@section('content')
@include('endUser.layouts.header')
    <div class="container-xl col-10">
        <div class="card mb-4">
            <div class="card-header bg-primary d-flex align-items-center mb-3">
                <h5 class="mb-0 text-light">ORDER DETAILS</h5>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <p>Username : <a class="text-primary " >
                                {{ $order->user->name }}</a></p>
                        <p>User Email : <a class="text-primary "
                                >
                                {{ $order->user->email }}</a></p>
                        @if ($order->address ?? false)
                            <p>User Phone : <a class="text-primary "
                                    > {{ $address->phone }}</a>
                            </p>
                            <p>Order Address To : <a class="text-primary "
                                    >
                                    {{ $address->country->name . ' , ' . ( $address->city_spare ) . ' , ' . $address->street . ' , ' . $address->building_number }}</a>
                            </p>
                        @endif
                    </div>
                    <div>
                        <p>Products Count : <span class="text-primary">{{ $orderitems->count() }}</span></p>
                        <p>Order Status : <span
                                class="
                            @if ($order->status == 'refunded') bg-label-danger me-1 p-1 rounded @endif
                            @if ($order->status == 'delivered') bg-label-success me-1 p-1 rounded @endif
                            @if ($order->status == 'pending') bg-label-primary me-1 p-1 rounded @endif
                            @if ($order->status == 'in_progress') bg-label-info me-1 p-1 rounded @endif
                        ">{{ str_replace('_', ' ', $order->status) }}
                            </span></p>
                        <p>Order Serial Number : <span class="text-primary">{{ $order->order_serial_code }}</span></p>
                        <p>Total Price : <span class="text-primary">${{ $order->total_price }}</span></p>
                    </div>
                </div>

                <div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Code</th>
                                <th>Product</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Price After Discount</th>
                                <th>Discount</th>
                                <th>Discount Value</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($orderitems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->order->order_serial_code }}</strong>
                                    </td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->color->name }}</td>
                                    <td>{{ $item->size->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->final_price }}</td>
                                    <td>
                                        <span
                                            class="

                                        @if ($item->discount) label bg-label-primary rounded p-1 @endif
                                        @if (!$item->discount) label bg-label-danger rounded p-1 @endif

                                        ">
                                        {{ ( $item->discount ?? 'no discount' ) . ( $item->discount ? '%' : null )}}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $item->discount_value ?? 'no discount' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
