<?php

namespace App\Http\Controllers\EndUser\ProductRate;

use App\Models\Rate;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRate\ProductRateStoreRequest;
use App\Traits\Api;
use Illuminate\Support\Facades\Validator;

class ProductRateController extends Controller
{

    use Api;

    public function store(Request $request){

        $rate = $request->get('rate');
        $comment = $request->get('comment');
        $product_id = $request->get('product_id');

        $validator = Validator::make([
            'rate'=>$rate,
            'comment'=>$comment,
            'product_id'=> $product_id
        ],[
            'rate'=>'required|gt:0|min:1|max:5',
            'comment'=>'required|min:10|max:500',
            'product_id'=>'required|gt:0|exists:products,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errors(),400);
        }

        $rate = Rate::create([
            'product_id'=>$product_id,
            'rate'=>$request->rate,
            'comment'=>$request->comment,
            'user_id'=>$request->user()->id
        ]);

        $rate->image = $request->user()->image;

        return $this->apiResponse('your review has been submited',$rate);

    }


    public function destroy(Request $request){
        $rate_id = $request->get('rate_id');
        $validator = Validator::make([
            'rate_id'=>$rate_id
        ],[
            'rate_id'=>'required|gt:0|exists:rates,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validatoin failed',null,$validator->errors(),400);
        }

        $rate = Rate::where('id',$rate_id)->first();
        if($rate->delete()){
            return $this->apiResponse('deleted',$rate);
        }
    }
}
