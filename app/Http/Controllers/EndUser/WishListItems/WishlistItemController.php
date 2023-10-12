<?php

namespace App\Http\Controllers\EndUser\WishListItems;

use App\Traits\Api;
use App\Models\Product;
use App\Models\WishList;
use App\Models\WishListItem;
use App\Traits\ErrorMessage;
use Illuminate\Http\Request;
use App\Traits\WishListExtra;
use GuzzleHttp\Psr7\MessageTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\WishListItem\WishListItemStoreRequest;

class WishlistItemController extends Controller
{

    use WishListExtra,ErrorMessage,Api;

    public function index(Request $request){
        if($request->ajax()){
            $wishlist = $request->get('wishlist');
            $query = trim($request->get('query'));
            $items = WishListItem::with('product:name,id,price,discount,image','wishlist')->where('wish_list_id',$wishlist)->get();
            // if($query && $query != null){
            //     $wishlist_items->whereHas('product',function($q) use ($query) {
            //         $q->where('name','like',"%{$query}%");
            //     });
            // }
            return view('endUser.pages.wishlists.wishlist-items',[
                'items'=>$items,
                'wishlist_id'=>$wishlist
            ]);
        }
    }

    public function store(Request $request){
        $product_id = $request->get('product_id');
        $wishlist_id = $request->get('wishlist_id');

        $validator = Validator::make([
            'product_id'=>$product_id,
            'wishlist_id'=>$wishlist_id
        ],[
            'product_id'=>'required|gt:0|exists:products,id',
            'wishlist_id'=>'required|gt:0|exists:wish_lists,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errors(),400);
        }

        $wishlist = WishList::where('id',$wishlist_id)->first();

        if(!$this->wishListItemCountCheck($wishlist->id)){
            return $this->apiResponse('wish list reached 20 items limit',null,null,406);
        }

            $wishlist_item = WishListItem::create([
                            'product_id'=>$product_id,
                            'wish_list_id'=>$wishlist->id
                        ]);
            $data = [
                'wishlist_items_count'=>$request->user()->wishListsItems()
            ];
            return $this->apiResponse('item added',$data);

    }
    public function destroy(Request $request){
        $id = $request->get('id');
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|gt:0|exists:wish_list_items,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation faild',null,$validator->errors(),422);
        }

        $wishlist_item = WishListItem::find($id);

        if(!$wishlist_item){
            return $this->apiResponse('Not Found',null,null,404);
        }

        if($wishlist_item->delete()){
            return $this->apiResponse('deleted');
        }
    }
}
