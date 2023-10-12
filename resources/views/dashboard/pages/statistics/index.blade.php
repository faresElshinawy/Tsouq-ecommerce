@extends('dashboard.layouts.master')


@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome {{ auth()->user()->name }}</h5>
                            <p class="mb-4">
                                Check Users Latest Orders From Here.
                            </p>

                            <a href="{{ route('orders.all') }}" class="btn btn-sm btn-outline-primary">View Orders</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-user label bg-label-success p-1 fs-3 rounded'></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="{{ route('users.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Online Users</span>
                            <h3 class="card-title mb-2">{{ $countOnlineUsers }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ round( ($countOnlineUsers / $countUsers) * 100 ) }} </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0 ">
                                    <img src="../assets/img/icons/unicons/wallet-info.png"  alt="Credit Card"
                                        class="rounded " />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('orders.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span >Sales</span>
                            <h3 class="card-title text-nowrap mb-1 my-2">${{ number_format($orderitems->sum('product.price')) }}</h3>
                            <small class="text-info fw-semibold">  {{ round(( $countDeliveredOrders / $countOrders) * 100) }} % </small>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">

                <div class="col-lg-6 col-md-12 col-sm-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-message-alt label bg-label-danger p-1 fs-3 rounded' ></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="{{ route('feedbacks.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block mb-1">Feedbacks</span>
                            <h3 class="card-title text-nowrap mb-2">{{ $feedbacks->count() }}</h3>
                            <small class="text-danger fw-semibold">  100 % </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bxs-contact label bg-label-primary p-1 fs-3 rounded'></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="{{ route('users.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Users</span>
                            <h3 class="card-title mb-2">{{ $countUsers}}</h3>
                            <small class="text-primary fw-semibold">  {{ round(($countUsers / $countUsers) * 100) }} % </small>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row  g-0">
                    <div class="col-md-8">
                        <a href="{{ route('feedbacks.all') }}">
                            <h5 class="card-header m-0 me-2 pb-3">Feedbacks</h5>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive text-nowrap">
                            <table class="table table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($feedbacks as $feedback)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                                <strong>{{ $feedback->name }}</strong>
                                            </td>
                                            <td>{{ $feedback->email }}</td>
                                            <td>{{ $feedback->subject }}</td>
                                            <td>{{ $feedback->message }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                                href="{{ route('feedbacks.edit', ['feedback' => $feedback->id]) }}"><i
                                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <form
                                                            action="{{ route('feedbacks.destroy', ['feedback' => $feedback->id]) }}"
                                                            method="Post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">

                <div class="col-lg-6 col-md-12 col-sm-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-shopping-bag label bg-label-secondary p-1 fs-3 rounded' ></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="{{ route('orders.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Orders</span>
                            <h3 class="card-title mb-2">{{$countOrders}}</h3>
                            <small class="text-muted fw-semibold">  {{round(($countOrders / \App\Models\Order::count()) * 100)}} %</small>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-purchase-tag-alt label bg-label-warning p-1 fs-3 rounded' ></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="{{ route('products.all') }}">View More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Products</span>
                            <h3 class="card-title mb-2">{{$countProducts}}</h3>
                            <small class="text-warning fw-semibold">  100 % </small>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="row mx-1">

        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <a href="{{ route('orders.all') }}">
                    <h5 class="card-title m-0 me-2">Latest Orders</h5>
                </a>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="{{ route('orders.all') }}">Show All Orders</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial Code</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Total Price</th>
                            <th>Total Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                    <strong>{{ $order->order_serial_code }}</strong>
                                </td>
                                <td>
                                    {{ $order->user->name }}
                                </td>
                                <td> <span
                                        class="
                                    @if ($order->status == 'rejected') bg-label-danger me-1 p-1 rounded @endif
                                    @if ($order->status == 'delivered') bg-label-success me-1 p-1 rounded @endif
                                    @if ($order->status == 'pending') bg-label-primary me-1 p-1 rounded @endif
                                    @if ($order->status == 'in_progress') bg-label-info me-1 p-1 rounded @endif
                                ">{{ str_replace('_', ' ', $order->status) }}</span>
                                </td>
                                <td>{{ $order->products->count() }}</td>
                                <td>{{ $order->products->sum('price') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('orders.edit', ['order' => $order->id]) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit & Details</a>
                                            <form action="{{ route('orders.destroy', ['order' => $order->id]) }}"
                                                method="Post">
                                                @csrf
                                                @method('delete')
                                                <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
