@if ($refunds->count())
<table class="table tabel-responsive table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Order Number</th>
            <th>Refund Reason</th>
            <th>Total Amount</th>
            <th>Transaction ID</th>
            {{-- <th>Actions</th> --}}
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($refunds as $refund)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                    <strong>{{ $refund->refundable->order_serial_code }}</strong>
                </td>
                <td>{{ $refund->refund_reason}}</td>
                <td>${{ $refund->total_amount}}</td>
                <td>{{ $refund->transaction_id}}</td>

            </tr>
        @endforeach
    </tbody>
</table>
<div class="m-3" id="ajax-pagination">
    {{ $refunds->links('pagination::bootstrap-5') }}
</div>
@else
    <div class="d-flex justify-content-center text-muted">
        No Refunds Results For This Order
    </div>
@endif
