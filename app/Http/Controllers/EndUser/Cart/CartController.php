<?php

namespace App\Http\Controllers\EndUser\Cart;

use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\CartExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use anlutro\LaravelSettings\Facades\Setting;

class CartController extends Controller
{
    use CartExtra;
    public function index(){
        $user_id = auth()->user()->id;
        $order = $this->getUserOrderId($user_id);
        $subTotal = CartExtra::calcSubTotal($order->items);
        $total = CartExtra::calcTotal($order->items) > 0 ? CartExtra::calcTotal($order->items) + Setting::get('tax') : 0;
        return view('endUser.pages.cart.index',[
            'items'=>OrderItem::with('product')->where('order_id', $order->id)->get(),
            'order_id'=>$order->id,
            'subTotal'=>$subTotal,
            'total'=> $total,
            'discount'=>number_format($subTotal - $total)
        ]);
    }
}
