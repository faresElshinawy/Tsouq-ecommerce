<?php

namespace App\Http\Controllers\EndUser\Wishlist;

use App\Traits\Api;
use App\Models\User;
use App\Models\WishList;
use App\Traits\ErrorMessage;
use Illuminate\Http\Request;
use App\Traits\WishListExtra;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\WishList\WishListStoreRequest;
use App\Http\Requests\WishList\WishListUpdateRequest;

class WishListController extends Controller
{

    use ErrorMessage, WishListExtra, Api;


    public function index(Request $request)
    {
        return view('endUser.pages.wishlists.index', [
            'wishlists' => Wishlist::where('user_id', $request->user()->id)->paginate(20),
        ]);
    }

    public function store(Request $request)
    {

        if (!$this->wishListCountCheck($request->user()->id)) {
            return $this->apiResponse('you have reached your wish lists limit',null,null,406);
        }

        $name = $request->get('name');
        $validator = Validator::make([
            'name' => $name,
        ], [
            'name' => Rule::unique('wish_lists', 'name')->where('user_id', $request->user()->id) . '|required|min:3|max:60'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse('validation error', null, $validator->errors(), 400);
        }

        $wishlist = WishList::create([
            'user_id' => $request->user()->id,
            'name' => $name
        ]);

        if($wishlist){
            return $this->apiResponse('wishlist'. ' ' .$wishlist->name . ' ' .'created successfully',$wishlist);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $wishlist = WishList::where('id', $request->get('id'))->first();
            if ($wishlist) {
                return $this->apiResponse('success', $wishlist);
            }
            return $this->apiResponse('not found', null, null, 400);
        }
    }

    public function update(Request $request)
    {
        $name = $request->get('name');
        $wishlist_id = $request->get('wishlist_id');
        $validator = Validator::make([
            'name' => $name,
            'wishlist_id' => $wishlist_id
        ], [
            'name' => Rule::unique('wish_lists', 'name')->where('user_id', $request->user()->id)->ignore($wishlist_id, 'id') . '|required|min:3|max:60',
            'wishlist_id'=>'required|gt:0|exists:wish_lists,id'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse('validation error', null, $validator->errors(), 400);
        }

        $wishlist = WishList::with('wishListItems')->where('id', $wishlist_id)->first();

        $wishlist->update([
            'name' => $name
        ]);
        $wishlist->count = $wishlist->wishListItems->count();
        return $this->apiResponse('success', $wishlist);
    }

    public function destroy(Request $request)
    {
        $wishlist_id = $request->get('wishlist_id');
        $validator = Validator::make([
            'wishlist_id' => $wishlist_id
        ], [
            'wishlist_id'=>'required|gt:0|exists:wish_lists,id'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse('validation error', null, $validator->errors(), 400);
        }

        $wishlist = WishList::where('id',$wishlist_id)->first();
        if($wishlist->delete()){
            $data = [
                'wishlists_items_count'=>User::wishListsItems(),
                'wishlists_count'=>WishList::where('user_id',Auth::user()->id)->count(),
            ];
            return $this->apiResponse('deleted',$data);
        }
    }
}
