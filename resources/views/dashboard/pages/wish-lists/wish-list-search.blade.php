
@if ($wishlists->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($wishlists as $wishlist)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $wishlist->name }}</strong>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            {{-- <a class="dropdown-item"
                                href="{{ route('wishlists.edit', ['wishlist' => $wishlist->id]) }}"><i
                                    class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                            @can('wishlist item')
                                <a class="dropdown-item"
                                    href="{{ route('wishlists.items.all', ['wishlist' => $wishlist->id]) }}"><i
                                        class="bx bx-edit-alt me-1"></i> items</a>
                            @endcan

                            @can('wishlist delete')
                                <form
                                    action="{{ route('wishlists.destroy', ['wishlist' => $wishlist->id]) }}"
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

    <div class="m-3" id="ajax-pagination">
        {{ $wishlists->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

