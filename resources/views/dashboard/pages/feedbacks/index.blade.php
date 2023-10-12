@extends('dashboard.layouts.master')


@section('title', 'feedbacks')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">feedbacks /</span> All feedbacks</h4>
            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="feedback-search" placeholder="Search...">
                    </div>
                    {{-- <a class="btn btn-primary text-white" href="{{ route('feedbacks.create') }}">Add New feedback</a> --}}
                </div>
                <div id="search-result">
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

                                                @can('feedbacks delete')    
                                                    <form
                                                        action="{{ route('feedbacks.destroy', ['feedback' => $feedback->id]) }}"
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
                    </div>
                    <div class="m-3">
                        {{ $feedbacks->links('pagination::bootstrap-5') }}
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
            $(document).on('keyup', '#feedback-search', function(e) {
                e.preventDefault();
                query = this.value;
                $.ajax({
                    url: "{{ route('feedbacks.search') }}",
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
            var query = $("#feedback-search").val();
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
