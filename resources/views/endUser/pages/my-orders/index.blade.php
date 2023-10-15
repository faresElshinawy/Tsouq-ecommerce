@extends('endUser.layouts.master')


@section('title','tsouq orders')


@section('page title',Setting::get('orders-header'))

@section('page',Setting::get('orders-title'))

@section('content')
@include('endUser.layouts.header')


<div class="container-xl col-10 flex-grow-1 container-p-y">
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <span class="text-light font-weight-bold">Filter By</span>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="orders_status">Status</label>
                <div class="col-sm-10">
                    <select name="status" id="orders_status"
                        class="form-control  @error('status') border-danger @enderror">
                        <option selected disabled>Select Order Status</option>
                        <option value=" ">all</option>
                        <option value="in_progress" @selected(old('status') == 'in_progress')>in progress</option>
                        <option value="delivered" @selected(old('status') == 'delivered')>delivered</option>
                        <option value="rejected" @selected(old('status') == 'rejected')>rejected</option>
                    </select>
                </div>
            </div>

            <div class=" mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-data">spacific date</label>
                <div class="d-flex">
                    <div class="col-6 m-1">
                        <label class="col-sm-2 col-form-label" for="basic-default-date">From :</label>
                        <input type="date" name="date-from" class="form-control" id="date_from">
                    </div>
                    <div class="col-6 m-1">
                        <label class="col-sm-2 col-form-label" for="basic-default-date" >To :</label>
                        <input type="date" name="date-to" class="form-control" id="date_to">
                    </div>
                </div>


            </div>

            <div class="justify-content-start">
                <button type="submit" class="btn btn-primary" id="orders-filter">Submit Filter</button>
            </div>
        </div>
    </div>
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
                            <th>Status</th>
                            <th>total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong class="text-primary">{{ $order->order_serial_code }}</strong>
                                </td>
                                <td> <span
                                        class="
                                    @if ($order->status == 'refunded') bg-label-danger me-1 p-1 rounded @endif
                                    @if ($order->status == 'delivered') bg-label-success me-1 p-1 rounded @endif
                                    @if ($order->status == 'pending') bg-label-primary me-1 p-1 rounded @endif
                                    @if ($order->status == 'in_progress') bg-label-info me-1 p-1 rounded @endif
                                ">{{ str_replace('_', ' ', $order->status) }}</span>
                                </td>
                                <td>{{ $order->status != 'pending' ? ($order->total_price ? $order->total_price : 'there is a problem cant get the final price') :  'not submited yet' }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{route('my-orders.show',['order'=>$order->id])}}"><i class='bx bx-detail' ></i> Details</a>
                                    <a class="btn btn-sm btn-muted" href="{{route('generate-pdf.create',['order'=>$order->id])}}"  target="_blank"><i class='bx bxs-file-pdf'></i> Export PDF</a>
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



@endsection



@section('js')
    <script>



        $(document).ready(function() {





            $(document).on('click', '#orders-filter', function(e) {
                e.preventDefault();
                var query = $('#order-search').val();
                var status = $('#orders_status').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                $.ajax({
                    url: "{{ route('my-orders.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'date_from':date_from,
                        'date_to':date_to,
                        'status':status
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });









            $(document).on('keyup', '#order-search', function(e) {
                e.preventDefault();
                var query = $(this).val();
                var status = $('#orders_status').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                $.ajax({
                    url: "{{ route('my-orders.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'date_from':date_from,
                        'date_to':date_to,
                        'status':status
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });





            $(document).on('click', '#ajax-pagination a', function(e) {
                e.preventDefault();
                var query = $('#order-search').val();
                var status = $('#orders_status').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'date_from':date_from,
                        'date_to':date_to,
                        'status':status
                    },
                    cache: false,
                    success: function(data) {
                        $('#search-result').html('');
                        $('#search-result').html(data);
                    }
                });
            })

        });

    </script>
@endsection
