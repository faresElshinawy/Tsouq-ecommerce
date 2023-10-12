<?php

namespace App\Http\Controllers\Dashboard\WishList;

use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:wishlist all', ['only' => ['index','search']]);
        // $this->middleware('permission:wishlist create', ['only' => ['create','store']]);
        // $this->middleware('permission:wishlist edit', ['only' => ['edit','update']]);
        $this->middleware('permission:wishlist delete', ['only' => ['destroy']]);
    }


    public function index(User $user){
        return view('dashboard.pages.wish-lists.index',[
            'wishlists'=>WishList::where('user_id',$user->id)->paginate(15),
            'user'=>$user
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $user_id = trim($request->get('user_id'));
            $wishlists = WishList::query()->where('name','like',"%{$query}%")->where('user_id',$user_id)->paginate(15);
            return view('dashboard.pages.wish-lists.wish-list-search',[
                'wishlists'=>$wishlists
            ]);
        }
    }

    public function destroy(WishList $wishlist){
        $wishlist->delete();
        return redirect()->back()->with('success','wishlist Deleted Successfully');
    }
}
