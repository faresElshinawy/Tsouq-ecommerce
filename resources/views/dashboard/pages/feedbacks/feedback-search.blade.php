@if ($feedbacks->count() > 0)
<div class="table table-responsive text-nowrap">
    <table class="table table-responsive table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                        <strong>{{ $feedback->name }}</strong>
                    </td>
                    <td>{{ $feedback->email }}</td>
                    <td>{{ $feedback->subject }}</td>
                    <td>{{ $feedback->message }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                {{-- <a class="dropdown-item"
                                        href="{{ route('feedbacks.edit', ['feedback' => $feedback->id]) }}"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                                <form
                                    action="{{ route('feedbacks.destroy', ['feedback' => $feedback->id]) }}"
                                    method="Post">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                        Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="m-3" id="ajax-pagination">
    {{ $feedbacks->links('pagination::bootstrap-5') }}
</div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif
