
@if ($settings->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>name</th>
            <th>value</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($settings as $setting)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $setting->key }}</strong>
                </td>
                <td>{{ $setting->value }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                                href="{{ route('settings.edit', ['setting' => $setting->id]) }}"><i
                                    class="bx bx-edit-alt me-1"></i> Edit</a>

                                <form action="{{ route('settings.destroy', ['setting' => $setting->id]) }}"
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

    <div class="m-3" id="ajax-pagination">
        {{ $settings->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

