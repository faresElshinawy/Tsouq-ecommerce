<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WishList;

class WishListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'wish_list_id',
        'product_id'
    ];

    public function wishlist(){
        return $this->belongsTo(WishList::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
