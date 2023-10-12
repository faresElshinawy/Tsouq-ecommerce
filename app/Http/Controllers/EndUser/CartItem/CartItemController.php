<?php

namespace App\Http\Controllers\EndUser\CartItem;

use App\Traits\Api;
use App\Models\Product;
use App\Models\OrderItem;
use App\Traits\CartExtra;
use App\Traits\ErrorMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Requests\Cart\CartItemStoreRequest;
use App\Http\Requests\Cart\CartItemUpdateRequest;

class CartItemController extends Controller
{

    use CartExtra,ErrorMessage,Api;


    public function store(Request $request){

        $validator = Validator::make([
            'size'=>$request->get('size'),
            'color'=>$request->get('color'),
            'quantity'=>$request->get('quantity'),
            'product_id'=>$request->get('product_id')
        ],[
            'size'=>'required|gt:0|exists:product_sizes,size_id',
            'color'=>'required|gt:0|exists:product_colors,color_id',
            'quantity'=>'required|gt:0',
            'product_id'=>'required|gt:0|exists:products,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('vaildation error',null,$validator->errors(),400);
        }

        $size = $request->get('size');
        $color = $request->get('color');
        $quantity = $request->get('quantity');
        $product = Product::where('id',$request->get('product_id'))->first();

        $order = $this->getUserOrderId($request->user()->id);

        if(!$order){
            return $this->apiResponse('adding to cart failed',null,null,417);
        }
        if($this->checkProductCount($product,$quantity)){
            return $this->apiResponse('seller only have ' . $product->count . ' right now',null,null,416);
        }

        if($itemExists = $this->checkIfItemExists($product->id,$request->user()->id,$order->id,$color,$size)){
            $itemExists->quantity = $quantity + $itemExists->quantity;
            $itemExists->save();

            return $this->apiResponse('item added successfully',$order->items->count());
        }

        $orderItem = OrderItem::create([
            'order_id'=>$order->id,
            'product_id'=>$product->id,
            'color_id'=>$color,
            'size_id'=>$size,
            'quantity'=>$quantity,
        ]);


        if($orderItem){
        return  $this->apiResponse('item added successfully',$order->items->count() + 1);
        }
    }


    public function update(Request $request){

        $item_id = $request->get('item_id');
        $quantity = $request->get('quantity');
        $validator = Validator::make([
            'quantity'=>$quantity,
            'item_id'=>$item_id
        ],[
            'quantity'=>'required|gt:0',
            'item_id'=>'required|gt:0|exists:order_items,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('vaildation error',null,$validator->errors(),400);
        }


        $orderitem = OrderItem::with('product:id,count')->where('id',$item_id)->first();

        if($this->checkProductCount($orderitem->product,$quantity)){
            return $this->apiResponse('seller only have ' . $orderitem->product->count . ' right now',null,null,416);
        }

        $orderitem->update([
            'quantity'=>$quantity,
        ]);

        $order = $this->getUserOrderId($request->user()->id);

        if(!$order){
            return $this->apiResponse('adding to cart failed',null,null,417);
        }

        $total = $this->calcTotal($order->items);
        $subTotal = $this->calcSubTotal($order->items);
        $discount = $subTotal - $total;

        $data = [
            'total'=>$total + Setting::get('tax'),
            'subTotal'=>$subTotal,
            'discount'=>$discount
        ];
        return $this->apiResponse('updated',$data);
    }

    public function destroy(Request $request){

        $id = $request->get('id');
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|gt:0|exists:order_items,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errors(),400);
        }

        $orderitem = OrderItem::find($id);

        if(!$orderitem){
            return $this->apiResponse('not found',null,null,404);
        }

        if($orderitem->delete()){
            $order = $this->getUserOrderId($request->user()->id);

            if(!$order){
                return $this->apiResponse('adding to cart failed',null,null,417);
            }

            $total = $this->calcTotal($order->items);
            $subTotal = $this->calcSubTotal($order->items);
            $discount = $subTotal - $total;

            $data = [
                'total'=>$total + Setting::get('tax'),
                'subTotal'=>$subTotal,
                'discount'=>$discount
            ];
            return $this->apiResponse('deleted',$data);
        }

    }
}
