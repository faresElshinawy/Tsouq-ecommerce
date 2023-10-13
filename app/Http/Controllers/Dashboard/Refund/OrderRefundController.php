<?php

namespace App\Http\Controllers\Dashboard\Refund;

use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Traits\PaymentHandler;
use App\Http\Controllers\Controller;

class OrderRefundController extends Controller
{

    use PaymentHandler;

    public function index(Request $request){
        $refunds = Refund::where('refundable_type','App\Models\Order');

        if($request->ajax()){
            $query = $request->get('query');
            $refunds->whereHasMorph('refundable',Order::class,function ($q) use($query) {
                $q->where('order_serial_code','like',"%{$query}%");
            });
            $refunds = $refunds->paginate();
            return view('dashboard.pages.refunds.orders-refunds.search',[
                'refunds'=>$refunds
            ]);
        }

        $refunds = $refunds->paginate();
        return view('dashboard.pages.refunds.orders-refunds.index',[
            'refunds'=>$refunds
        ]);
    }

    public function create(Order $order){
        return view('dashboard.pages.refunds.orders-refunds.create',[
            'order'=>$order
        ]);
    }

    public function store(Request $request,Order $order){
        if($this->processRefund($request,$order)){
            $order->status = 'refunded';
            return redirect()->back()->with('Successful Refund process');
        }

        return redirect()->back()->with('error','Failed to process your refund');
    }
}
