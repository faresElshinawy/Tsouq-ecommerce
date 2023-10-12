
@if ($subscribers->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($subscribers as $subscriber)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $subscriber->name }}</strong>
                </td>
                <td>{{ $subscriber->email }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">

                            @can('subscriber delete')
                                <form action="{{ route('subscribers.destroy', ['subscriber' => $subscriber->id]) }}"
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
        {{ $subscribers->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

