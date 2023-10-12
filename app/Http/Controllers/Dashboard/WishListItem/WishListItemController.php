<?php

namespace App\Http\Controllers\Dashboard\WishListItem;

use App\Models\WishList;
use App\Models\WishListItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListItemController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:wishlist item', ['only' => ['index','search']]);
        // $this->middleware('permission:voucher create', ['only' => ['create','store']]);
        // $this->middleware('permission:voucher edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:voucher delete', ['only' => ['destroy']]);
    }

    public function index(WishList $wishlist){
        return view('dashboard.pages.wish-lists.wish-list-items.index',[
            'items'=>WishListItem::with('product:id,name')->where('wish_list_id',$wishlist->id)->paginate(15),
            'wishlist'=>$wishlist
        ]);
    }
}
