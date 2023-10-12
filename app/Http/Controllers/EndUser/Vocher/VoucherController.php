<?php

namespace App\Http\Controllers\EndUser\Vocher;

use App\Traits\Api;
use App\Models\Order;
use App\Models\Voucher;
use App\Traits\CartExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    use Api,CartExtra;

    public function apply(Request $request){
        $voucher = $request->get('voucher');
        $order_id = $request->get('order_id');
        $voucher = Voucher::where('code','like',"%{$voucher}%")->first();
        $order = Order::with('items')->where('id',$order_id)->first();
        $total = CartExtra::calcTotal($order->items) + 10;
        $new_price = 0;

        if($voucher->type == 'percentage'){
            $new_price = $total - $voucher->value / 100 * $total;
        }elseif($voucher->type == 'row_discount'){
            $new_price = $total - $voucher->value;
        }
        $new_price = round($new_price);


        Session::put('voucher',[
            'discount_value'=>round($total - $new_price),
            'voucher_code'=>$voucher->code
        ]);

        return $this->apiResponse('Voucher Applied Note That Any Refresh To This Page Will Earse The Voucher Discount!',['new_price'=>$new_price , 'total'=>$total ,'discount'=>round($total - $new_price),'voucher_id'=>$voucher->id]);

    }


    public function destroy(Request $request){
        $order_id = $request->get('order_id');
        $order = Order::with('items')->where('id',$order_id)->first();
        $total = CartExtra::calcTotal($order->items) + 10;
        if(Session::has('voucher')){
            Session::forget('voucher');
            return $this->apiResponse('Voucher Deleted',['total'=>$total]);
        }
        return $this->apiResponse('No Voucher To Delete',null,null,400);
    }
}
