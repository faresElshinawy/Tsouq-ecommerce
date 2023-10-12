<?php

namespace App\Traits;

use App\Models\WishList;
use App\Models\WishListItem;

trait WishListExtra
{
    public function wishListCountCheck($user_id){
        if(WishList::where('user_id',$user_id)->count() >= 20){
            return false;
        }
        return true;
    }


    public function wishListItemCountCheck($wishlist_id){
        if(WishListItem::where('wish_list_id',$wishlist_id)->count() >= 20){
            return false;
        }
        return true;
    }


}
