@extends('dashboard.layouts.master')


@section('title', 'vouchers')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">vouchers /</span>vouchers</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="voucher-search" placeholder="Search...">
                    </div>
                    @can('voucher create')
                        <a class="btn btn-primary text-white" href="{{ route('vouchers.create') }}">Add New voucher</a>
                    @endcan
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Value</th>
                                    <th>Price Limit</th>
                                    <th>type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $voucher->code }}</strong>
                                        </td>
                                        <td>
                                            {{ $voucher->value }}
                                            @if ($voucher->type == 'percentage')
                                                {{ ' %' }}
                                            @elseif($voucher->type == 'row_discount')
                                                {{ "$" }}
                                            @endif
                                        </td>
                                        <td>{{ $voucher->price_limit }}</td>
                                        <td> <span
                                                class="
                                                @if ($voucher->type == 'percentage') badge bg-label-primary me-1 p-1 rounded @endif
                                                @if ($voucher->type == 'row_discount') badge bg-label-warning me-1 p-1 rounded @endif
                                        ">{{ str_replace('_',' ',$voucher->type) }}</span>
                                        </td>
                                        <td> <span
                                                class="
                                            @if ($voucher->status == 'active') bg-label-success me-1 p-1 rounded @endif
                                            @if ($voucher->status == 'inactive') bg-label-danger me-1 p-1 rounded @endif
                                        ">{{ $voucher->status }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">

                                                    @can('voucher edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('vouchers.edit', ['voucher' => $voucher->id]) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    @endcan

                                                    @can('voucher delete')
                                                        <form
                                                            action="{{ route('vouchers.destroy', ['voucher' => $voucher->id]) }}"
                                                            method="Post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                                Delete</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $vouchers->links('pagination::bootstrap-5') }}
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
            $(document).on('keyup', '#voucher-search', function(e) {
                e.preventDefault();
                query = this.value;
                $.ajax({
                    url: "{{ route('vouchers.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}"
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
            var query = $("#voucher-search").val();
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
