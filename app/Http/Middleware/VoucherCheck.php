<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use App\Models\Voucher;
use App\Traits\Api;
use App\Traits\CartExtra;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class VoucherCheck
{
    use Api;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $voucher = trim($request->get('voucher'));
        $order_id = $request->get('order_id');
        $voucher = Voucher::where('code','like',"%{$voucher}%")->first();
        $order = Order::with('items')->where('id',$order_id)->first();
        $total = CartExtra::calcTotal($order->items);

        if(!$voucher){
            return $this->apiResponse('Voucher Not Found!',null,null,404);
        }

        if($voucher->status != 'active'){
            return $this->apiResponse('Voucher Ended!',null,null,400);
        }

        if($total < $voucher->price_limit){
            return $this->apiResponse('voucher not allowed for orders under $' . $voucher->price_limit . '!',null,null,400);
        }

        return $next($request);
    }
}
