
@if ($vouchers->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Value</th>
            <th>Price Limit</th>
            <th>type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($vouchers as $voucher)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $voucher->code }}</strong>
                </td>
                <td>
                    {{ $voucher->value }}
                    @if ($voucher->type == 'percentage')
                        {{ ' %' }}
                    @elseif($voucher->type == 'row_discount')
                        {{ "$" }}
                    @endif
                </td>
                <td>{{ $voucher->price_limit }}</td>
                <td> <span
                        class="
                        @if ($voucher->type == 'percentage') badge bg-label-primary me-1 p-1 rounded @endif
                        @if ($voucher->type == 'row_discount') badge bg-label-warning me-1 p-1 rounded @endif
                ">{{ str_replace('_',' ',$voucher->type) }}</span>
                </td>
                <td> <span
                        class="
                    @if ($voucher->status == 'active') bg-label-success me-1 p-1 rounded @endif
                    @if ($voucher->status == 'inactive') bg-label-danger me-1 p-1 rounded @endif
                ">{{ $voucher->status }}</span>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">

                            @can('voucher edit')
                                <a class="dropdown-item"
                                    href="{{ route('vouchers.edit', ['voucher' => $voucher->id]) }}"><i
                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                            @endcan

                            @can('voucher delete')
                                <form
                                    action="{{ route('vouchers.destroy', ['voucher' => $voucher->id]) }}"
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
        {{ $vouchers->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

