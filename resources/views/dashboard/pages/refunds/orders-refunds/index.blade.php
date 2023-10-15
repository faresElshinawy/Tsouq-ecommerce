@extends('dashboard.layouts.master')


@section('title', 'refunds')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">order refunds /</span>refunds</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="refund-search" placeholder="Search...">
                    </div>
                    @can('refund create')
                    {{-- <a class="btn btn-primary text-white" href="{{ route('refunds.create') }}">Add New refund</a> --}}
                    @endcan
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table tabel-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Refund Reason</th>
                                    <th>Total Amount</th>
                                    <th>Transaction ID</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($refunds as $refund)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $refund->refundable->order_serial_code }}</strong>
                                        </td>
                                        <td>{{ $refund->refund_reason}}</td>
                                        <td>${{ $refund->total_amount}}</td>
                                        <td>{{ $refund->transaction_id}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $refunds->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
    $(document).ready(function(){
        $(document).on('keyup','#refund-search',function(e){
            e.preventDefault();
            query = this.value;
            $.ajax({
                url:"{{route('orders-refunds.all')}}",
                type:'get',
                data:{"query":query , "_token":"{{csrf_token()}}" },
                datatype:'html',
                cache:false,
                success:function(data){
                    $('#search-result').empty().html(data)
                }
            })
        });
    });

    $(document).on('click','#ajax-pagination a',function(e){
            e.preventDefault();
            var query = $("#refund-search").val();
            $.ajax({
                url: $(this).attr('href'),
                type: "get",
                datatype:'html',
                data: {
                    "query": query,
                    '_token': "{{ csrf_token() }}"
                },
                cache:false,
                success: function(data) {
                    $('#search-result').html('');
                    $('#search-result').html(data);
                }
            });
        })

</script>
@endsection
