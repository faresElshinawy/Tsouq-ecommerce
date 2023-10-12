@extends('dashboard.layouts.master')


@section('title', 'roles')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">roles /</span> All roles</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        {{-- <input type="text" class="form-control" id="role-search" placeholder="Search..."> --}}
                    </div>
                    @can('role create')
                        <a class="btn btn-primary text-white" href="{{ route('roles.create') }}">Add New role</a>
                    @endcan
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $role->name }}</strong>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('role edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('roles.edit', ['id' => $role->id]) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    @endcan
                                                @can('role delete')
                                                    @if ($role->name != 'owner' or $role->name != 'seller' or $role->name != 'user')
                                                        <form action="{{ route('roles.destroy', ['id' => $role->id]) }}"
                                                            method="Post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                                Delete</button>
                                                        </form>
                                                    @endif
                                                @endcan

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $roles->links('pagination::bootstrap-5') }}
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
        $(document).on('keyup','#role-search',function(e){
            e.preventDefault();
            query = this.value;
            $.ajax({
                url:"{{route('roles.search')}}",
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
            var query = $("#role-search").val();
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
