
@if ($orders->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Serial Code</th>
            <th>Status</th>
            <th>total Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong class="text-primary">{{ $order->order_serial_code }}</strong>
                </td>
                <td> <span
                        class="
                    @if ($order->status == 'refunded') bg-label-danger me-1 p-1 rounded @endif
                    @if ($order->status == 'delivered') bg-label-success me-1 p-1 rounded @endif
                    @if ($order->status == 'pending') bg-label-primary me-1 p-1 rounded @endif
                    @if ($order->status == 'in_progress') bg-label-info me-1 p-1 rounded @endif
                ">{{ str_replace('_', ' ', $order->status) }}</span>
                </td>
                <td>{{ $order->status != 'pending' ? ($order->total_price ? $order->total_price : 'there is a problem cant get the final price') :  'not submited yet' }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{route('my-orders.show',['order'=>$order->id])}}"><i class='bx bx-detail' ></i> Details</a>
                    <a class="btn btn-sm btn-muted" href="{{route('generate-pdf.create',['order'=>$order->id])}}"  target="_blank"><i class='bx bxs-file-pdf'></i> Export PDF</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <div class="m-3" id="ajax-pagination">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

