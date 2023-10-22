@extends('dashboard.layouts.master')

@section('title', 'addresses')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ $user }} /</span> All address</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    {{-- <div class="col-3">
                        <input type="text" class="form-control" id="address-search" placeholder="Search...">
                    </div> --}}
                    {{-- <a class="btn btn-primary text-white" href="{{ route('addresses.create') }}">Add New address</a> --}}
                </div>
                <div class="table table-responsive text-nowrap ">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>street</th>
                                    <th>country</th>
                                    <th>country code</th>
                                    <th>city</th>
                                    <th>bulding No</th>
                                    <th>phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($addresses as $address)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $address->street }}</strong>
                                        </td>
                                        <td>{{ $address->country->name }}</td>
                                        <td>{{ $address->country->code }}</td>
                                        <td>{{  $address->city_spare  }}</td>
                                        <td>{{ $address->building_number }}</td>
                                        <td>{{ $address->phone }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('address edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.addresses.edit', ['address' => $address->id]) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $addresses->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @section('js')
    <script>
        $("#address-search").on("keyup", function() {
            var query = this.value;
            $.ajax({
                url: "{{ route('addresses.search') }}",
                type: "POST",
                datatype:'html',
                data: {
                    "query": query,
                    "_token": "{{csrf_token()}}"
                },
                cache:false,
                success: function(data) {
                    $('#search-result').html('');
                    $('#search-result').html(data)
                },
            });
        });

        $(document).on('click','#ajax-pagination a',function(e){
            e.preventDefault();
            var query = $("#address-search").val();
            $.ajax({
                url: $(this).attr('href'),
                type: "post",
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
        // $("#ajax-pagination").on("click", function(e) {
        //     var query = this.value;
        //     $.ajax({
        //         url: $(this).attr('href'),
        //         type: "POST",
        //         datatype:'html',
        //         data: {
        //             "query": query,
        //             '_token': "{{ csrf_token() }}"
        //         },
        //         cache:false,
        //         success: function(data) {
        //             $('#search-result').html('');
        //             $('#search-result').html(data)
        //         }
        //     });
        // });
    </script>
@endsection --}}
