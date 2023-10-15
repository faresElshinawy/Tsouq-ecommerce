@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center mb-3">
                <h5 class="mb-0">ORDER DETAILS</h5>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <p>Username : <a class="text-primary " href="{{ route('users.edit', ['user' => $order->user->id]) }}">
                                {{ $order->user->name }}</a></p>
                        <p>User Email : <a class="text-primary "
                                href="{{ route('users.edit', ['user' => $order->user->id]) }}">
                                {{ $order->user->email }}</a></p>
                        @if ($order->address ?? false)
                            <p>User Phone : <a class="text-primary "
                                    href="{{ route('users.edit', ['user' => $order->user->id]) }}">
                                    {{ $order->address->phone }}</a>
                            </p>
                            <p>Order Address To : <a class="text-primary "
                                    href="{{ route('users.addresses.edit', ['address' => $order->address_id]) }}">
                                    {{ $order->address->country->name . ' , ' . $order->address->city_spare . ' , ' . $order->address->street . ' , ' . $order->address->building_number }}</a>
                            </p>
                        @endif
                    </div>
                    <div>
                        <p>Products Count : <span class="text-primary">{{ $order->items->count() }}</span></p>
                        <p>Order Status : <span
                                class="
                            @if ($order->status == 'rejected') bg-label-danger me-1 p-1 rounded @endif
                            @if ($order->status == 'delivered') bg-label-success me-1 p-1 rounded @endif
                            @if ($order->status == 'in_progress') bg-label-primary me-1 p-1 rounded @endif
                            @if ($order->status == 'shipped') bg-label-dark me-1 p-1 rounded @endif
                        ">{{ str_replace('_', ' ', $order->status) }}
                            </span></p>
                        <p>Order Serial Number : <span class="text-primary">{{ $order->order_serial_code }}</span></p>
                        <p>Total Price : <span class="text-primary">${{ $order->total_price }}</span></p>
                    </div>
                </div>


                <form action='{{ route('orders.update', ['order' => $order->id]) }}' method="POST" class="my-3">
                    @csrf
                    @method('put')


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-status">Change Order status</label>
                        <div class="col-sm-10">
                            <select name="status" class="form-control @error('status') border-danger @enderror"
                                id="basic-default-status">
                                <option selected disabled>select order type</option>
                                @foreach ($status as $status_opt)
                                    <option value="{{ $status_opt }}" @selected($status_opt == old('status') || $status_opt == $order->status)>
                                        {{ str_replace('_', ' ', $status_opt) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-status">Send Customer Notify
                            Message</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input @error('status') border-danger @enderror" type="checkbox"
                                    value="true" id="user-notify-message" name="sms_approved" />
                                <label class="form-check-label" for="user-notify-message"> Approved </label>
                            </div>
                        </div>
                    </div>



                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>

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
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
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
                                            {{ ($item->discount ?? 'no discount') . ($item->discount ? '%' : null) }}
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
