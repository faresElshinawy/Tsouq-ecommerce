@extends('dashboard.layouts.master')


@section('title', 'credit cards')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$user->name}} /</span> credit cards</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="credit-card-search" placeholder="Search...">
                    </div>
                    {{-- <a class="btn btn-primary text-white" href="{{ route('credit-cards.create') }}">Add New credit-card</a> --}}
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Holder Name</th>
                                    <th>Card Number</th>
                                    <th>cvv</th>
                                    <th>exire date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($creditcards as $creditcard)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $creditcard->holder_name }}</strong>
                                        </td>
                                        <td>{{ $creditcard->cvv}}</td>
                                        <td>{{ $creditcard->card_number }}</td>
                                        <td>{{ $creditcard->expire_month . '/' . $creditcard->expire_year }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('creditcards.edit', ['credit-card' => $creditcard->id]) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                                                    @can('user creditcard delete')
                                                        <form
                                                            action="{{ route('credit-cards.destroy', ['creditcard' => $creditcard->id]) }}"
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
                            {{ $creditcards->links('pagination::bootstrap-5') }}
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
            $(document).on('keyup', '#credit-card-search', function(e) {
                e.preventDefault();
                query = this.value;
                $.ajax({
                    url: "{{ route('credit-cards.search',['user'=>$user->id]) }}",
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
            var query = $("#credit-card-search").val();
            $.ajax({
                url: $(this).attr('href'),
                type: "post",
                datatype: 'html',
                data: {
                    "query": query,
                    "user_id":"{{$user->id}}",
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
