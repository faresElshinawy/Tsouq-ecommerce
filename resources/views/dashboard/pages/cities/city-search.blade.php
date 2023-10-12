
@if ($cities->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($cities as $city)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $city->name }}</strong>
                </td>
                <td>
                    {{-- <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> --}}
                        {{ $city->country?->name }}
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">

                            @can('city edit')
                            <a class="dropdown-item"
                                href="{{ route('cities.edit', ['city' => $city->id]) }}"><i
                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                            @endcan

                            @can('city delete')
                                <form action="{{ route('cities.destroy', ['city' => $city->id]) }}"
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
        {{ $cities->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

