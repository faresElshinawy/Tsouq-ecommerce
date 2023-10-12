
@if ($creditcards->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Holder Name</th>
            <th>Card Number</th>
            <th>cvv</th>
            <th>exire date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($creditcards as $creditcard)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $creditcard->holder_name }}</strong>
                </td>
                <td>{{ $creditcard->cvv}}</td>
                <td>{{ $creditcard->card_number }}</td>
                <td>{{ $creditcard->expire_month . '/' . $creditcard->expire_year }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            {{-- <a class="dropdown-item"
                                href="{{ route('creditcards.edit', ['credit-card' => $creditcard->id]) }}"><i
                                    class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                            <form
                                action="{{ route('credit-cards.destroy', ['creditCard' => $creditcard->id]) }}"
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
        {{ $creditcards->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

