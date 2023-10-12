<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\ProductColor;

trait CartExtra {

    use ErrorMessage;

    public static function calcTotal($items){
        $total = 0;
        foreach ($items as $item){
            $total += ($item->product->price - (($item->product->discount / 100) * $item->product->price)) * $item->quantity;
        }
        return round($total);
    }

    public static function calcSubTotal($items){
        $subTotal = 0;
        foreach ($items as $item){
            $subTotal += $item->product->price  * $item->quantity;
        }
        return round($subTotal);
    }


    public static function getUserOrderId($user_id){
        $order = Order::with('items')->where('user_id',$user_id)->where('status','pending')->first();

        if($order){
            return $order;
        }
        $order = Order::create([
            'order_serial_code'=>'test',
            'user_id'=>$user_id
        ]);
        $serial_code = 'ord-ser-' . $order->id ;
        $order->order_serial_code = $serial_code;
        $order->save();

        if($order){
            return $order;
        }

        return false;
    }

    public function checkProductCount($product,$quantity){
        if($product->count >= $quantity){
            return false;
        }
        return true;
    }


    public function checkIfItemExists($product_id,$user_id,$order_id,$color,$size){
        $item = OrderItem::where('order_id',$order_id)->where('product_id',$product_id)->where('color_id',$color)
        ->where('size_id',$size)->first();
        if($item){
            return $item;
        }
        return false;
    }




}
