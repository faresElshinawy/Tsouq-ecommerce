@extends('dashboard.layouts.master')


@section('title', 'countries')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">countries /</span> All countries</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="country-search" placeholder="Search...">
                    </div>
                    @can('country create')
                    <a class="btn btn-primary text-white" href="{{ route('countries.create') }}">Add New country</a>
                    @endcan
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($countries as $country)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $country->name }}</strong>
                                        </td>
                                        <td>{{ $country->code }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('country edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('countries.edit', ['country' => $country->id]) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    @endcan

                                                    @can('country delete')
                                                        <form action="{{ route('countries.destroy', ['country' => $country->id]) }}"
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
                            {{ $countries->links('pagination::bootstrap-5') }}
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
        $(document).on('keyup','#country-search',function(e){
            e.preventDefault();
            query = this.value;
            $.ajax({
                url:"{{route('countries.search')}}",
                type:'POST',
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
            var query = $("#country-search").val();
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

</script>
@endsection
