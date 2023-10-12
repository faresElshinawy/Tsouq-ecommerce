@extends('dashboard.layouts.master')


@section('title', 'items')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$wishlist->name ?? 'items'}} /</span>items</h4>
            <div class="card">
                {{-- <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="item-search" placeholder="Search...">
                    </div>
                    <a class="btn btn-primary text-white" href="{{ route('items.create') }}">Add New item</a>
                </div> --}}
                <div class="table text-nowrap">
                    <div id="search-result">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                            <strong>{{ $item->product->name }}</strong>
                                        </td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('items.edit', ['item' => $item->id]) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <form action="{{ route('items.destroy', ['item' => $item->id]) }}"
                                                        method="Post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                            Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-3">
                            {{ $items->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @section('js')
<script>
    $(document).ready(function(){
        $(document).on('keyup','#item-search',function(e){
            e.preventDefault();
            query = this.value;
            $.ajax({
                url:"{{route('items.search')}}",
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
            var query = $("#item-search").val();
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
@endsection --}}
