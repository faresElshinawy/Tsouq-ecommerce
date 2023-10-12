<?php

namespace App\Http\Controllers\EndUser\Order;

use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request){
        return view('endUser.pages.my-orders.index',[
            'orders'=>Order::with('user','products:price,id')->where('status','!=','pending')->where('user_id',$request->user()->id)->orderBy('total_price','asc')->paginate()
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $status = $request->get('status');
            $date_from = $request->get('date_from');
            $date_to = $request->get('date_to');
            $orders = Order::query()->with('user')->where('status','!=','pending')->where('user_id',$request->user()->id);

            if($query != null){
                $orders->Where('order_serial_code','like',"%{$query}%");
            }

            if($status != null){
                $orders->where('status',$status);
            }

            if($date_from != null && $date_to != null){
                $orders->whereBetween('created_at',[$date_from,$date_to]);
            }


            return view('endUser.pages.my-orders.order-search',[
                'orders'=>$orders->paginate()
            ]);
        }
    }

    public function Details(Order $order){
        return view('endUser.pages.my-orders.details',[
            'order'=>$order,
            'address'=>Address::where('id',$order->address_id)->with('country:name,id','city:name,id')->first(),
            'orderitems'=>OrderItem::query()->where('order_id',$order->id)->get()
        ]);
    }
}
