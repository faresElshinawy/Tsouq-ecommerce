<?php

namespace App\Http\Controllers\Dashboard\Rate;

use App\Models\Rate;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RateController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:products rate', ['only' => ['index','search']]);
        // $this->middleware('permission:size create', ['only' => ['create','store']]);
        // $this->middleware('permission:size edit', ['only' => ['edit','update']]);
        $this->middleware('permission:products rate delete', ['only' => ['destroy']]);
    }

    public function index(Product $product){
        return view('dashboard.pages.products.product-rates',[
            'rates'=>Rate::query()->with('user:name,id')->where('product_id',$product->id)->paginate(15),
            'product'=>$product
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $product_id = trim($request->get('product_id'));
            $rates = Rate::query()->with('user:name,id')->where('product_id',$product_id)->
            whereHas('user',function($rateQuery) use ($query) {
                $rateQuery->where('name','like',"%{$query}%");
            })->
            where('comment','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.products.product-rate-search',[
                'rates'=>$rates,
            ]);
        }
    }

    public function destroy(Rate $rate){
        $rate->delete();
        return redirect()->back()->with('success','rate deleted successfully');
    }
}
