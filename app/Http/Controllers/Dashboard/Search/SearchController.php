<?php

namespace App\Http\Controllers\Dashboard\Search;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request){

        $query = trim($request->multi_search);



        if(User::where('name','like',"%{$query}%")->orWhere('email','like',"%{$query}%")->first()){
            $users = User::query();
            $users->where('name','like',"%{$query}%")->orWhere('email','like',"%{$query}%");
            return view('dashboard.pages.users.index',['users'=>$users->paginate(15)]);
        }


        if(Product::with('category','brand','user')->where('name','like',"%{$query}%")->orWhere('description','like',"%{$query}%")->first()){
            $products = Product::query()->with('category','brand','user')->where('name','like',"%{$query}%")->orWhere('description','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.products.index',[
                'products'=>$products
            ]);
        }



        if(Voucher::query()->where('code','like',"%{$query}%")->first()){
            $vouchers = Voucher::query()->where('code','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.vouchers.index',[
                'vouchers'=>$vouchers
            ]);
        }


        if(Order::query()->with('user')->Where('order_serial_code','like',"%{$query}")->first()){
            $orders = Order::query()->with('user')->Where('order_serial_code','like',"%{$query}")->paginate(15);
            return view('dashboard.pages.orders.index',[
                'orders'=>$orders
            ]);
        }


        $products = Product::query()->with('category','brand','user')->where('name','like',"%{$query}%")->orWhere('description','like',"%{$query}%")->paginate(15);
        return view('dashboard.pages.products.index',[
            'products'=>$products
        ]);



    }
}
