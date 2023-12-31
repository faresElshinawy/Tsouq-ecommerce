@extends('dashboard.layouts.master')


@section('title', 'orders')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">orders /</span> orders</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="order-search" placeholder="Search...">
                    </div>
                    {{-- <a class="btn btn-primary text-white" href="{{ route('orders.create') }}">Add New order</a> --}}
                </div>
                <div class="table table-responsive text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Serial Code</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Total Price</th>
                                    <th>Total Products</th>
                                    <th>Final Price</th>
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
                                            @if ($order->status == 'in_progress') bg-label-primary me-1 p-1 rounded @endif
                                            @if ($order->status == 'shipped') bg-label-dark me-1 p-1 rounded @endif
                                        ">{{ str_replace('_', ' ', $order->status) }}</span>
                                        </td>
                                        <td>{{ $order->products->sum('price') }}</td>
                                        <td>{{ $order->products->count() }}</td>
                                        <td>{{ $order->status != 'pending' ? ($order->total_price ? $order->total_price : 'there is a problem cant get the final price') :  'not submited yet' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($order->status != 'pending')
                                                        <a class="dropdown-item"
                                                            href="{{ route('orders.edit', ['order' => $order->id]) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit & Details</a>
                                                    @endif
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
                        <div class="m-3">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '#order-search', function(e) {
                e.preventDefault();
                query = this.value;
                $.ajax({
                    url: "{{ route('users.orders.order-search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'user_id':"{{$user->id}}"
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });
        });

        $(document).on('click', '#ajax-pagination a', function(e) {
            e.preventDefault();
            var query = $("#order-search").val();
            $.ajax({
                url: $(this).attr('href'),
                type: "post",
                datatype: 'html',
                data: {
                    "query": query,
                    '_token': "{{ csrf_token() }}"
                },
                cache: false,
                success: function(data) {
                    $('#search-result').html('');
                    $('#search-result').html(data);
                }
            });
        })
    </script>
@endsection
