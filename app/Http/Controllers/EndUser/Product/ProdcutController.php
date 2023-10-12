<?php

namespace App\Http\Controllers\EndUser\Product;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProdcutController extends Controller
{


    public function index(Request $request,Product $product){

        $buttons = \Share::page(route('products-details.show',['product'=>$product->id]))
        ->facebook()
        ->twitter()
        ->pinterest()
        ->telegram();

        return view('endUser.pages.product-detail.index',[
        'product'=>$product,
        'product_rates'=>Rate::with('user:name,image,id')->where('product_id',$product->id)->orderBy('created_at','desc')->paginate(5),
        'products'=>Product::where('category_id',$product->category_id)->limit(8)->get(),
        'shareButtons'=>$buttons,
        ]);
    }


    public function productRates(Request $request,Product $product){
        if($request->ajax()){
            return view('endUser.pages.product-detail.product-rates',[
                'product_rates'=>Rate::with('user:name,image,id')->where('product_id',$product->id)->orderBy('created_at','desc')->paginate(5)
            ]);
        }
    }
}
