<?php

namespace App\Http\Controllers\Dashboard\Statistics;

use App\Models\User;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:access dashboard', ['only' => ['index']]);
    }

    public function index(){
        return view('dashboard.pages.statistics.index',[
            'orderitems'=>OrderItem::with('order:status,id','product:price,id','product:category:name,id')->whereHas('order',function ($query) {
                $query->where('status','delivered');
            })->get(),
            'countUsers'=>User::whereJsonContains('roles_name','user')->count(),
            'refundsTotal'=>Refund::get()->sum('total_amount'),
            'countUsers'=>User::count(),
            'countProducts'=>Product::count(),
            'countOrders'=>Order::where('status','!=','pending')->count(),
            'countDeliveredOrders'=>Order::where('status','delivered')->count(),
            'feedbacks'=>Feedback::limit(5)->get(),
            'orders'=>Order::with('user','products:price,id')->orderBy('created_at','desc')->where('status','in_progress')->limit(6)->get()
        ]);
    }

}
