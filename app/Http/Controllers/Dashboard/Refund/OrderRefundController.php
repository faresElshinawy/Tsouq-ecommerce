<?php

namespace App\Http\Controllers\Dashboard\Refund;

use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Traits\PaymentHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Refund\RefundStoreRequest;

class OrderRefundController extends Controller
{

    use PaymentHandler;

    public function __construct()
    {
        $this->middleware('refund all')->only('index');
        $this->middleware('set refund')->only(['create','store']);
    }

    public function index(Request $request)
    {
        $refunds = Refund::where('refundable_type', 'App\Models\Order');

        if ($request->ajax()) {
            $query = $request->get('query');
            $refunds->whereHasMorph('refundable', Order::class, function ($q) use ($query) {
                $q->where('order_serial_code', 'like', "%{$query}%");
            });
            $refunds = $refunds->paginate();
            return view('dashboard.pages.refunds.orders-refunds.search', [
                'refunds' => $refunds
            ]);
        }

        $refunds = $refunds->paginate();
        return view('dashboard.pages.refunds.orders-refunds.index', [
            'refunds' => $refunds
        ]);
    }

    public function create(Order $order)
    {
        return view('dashboard.pages.refunds.orders-refunds.create', [
            'order' => $order
        ]);
    }

    public function store(RefundStoreRequest $request, Order $order)
    {

        $refundAmount = $request->refund_amount;
        $refundReason = $request->refund_reason;

        if ($order->status == 'refunded') {
            return redirect()->back()->with('error', 'Order Already Refunded');
        }

        $status = $this->processRefund($order);
        if ($status === 'COMPLETED') {
            Refund::created([
                'refundable_id'=>$order->id,
                'refundable_type'=>'App\Models\Order',
                'total_amount'=>$refundAmount,
                'refund_reason'=>$refundReason
            ]);
            $order->status = 'refunded';
            return redirect()->back()->with('success','Successful Refund process');
        }
        return redirect()->back()->with('error',$status);
    }
}
