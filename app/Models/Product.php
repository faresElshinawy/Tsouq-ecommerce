<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,Searchable,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'count',
        'discount',
        'category_id',
        'brand_id',
        'user_id',
        'image',
        'solded_out',
        'refunds',
        'total_gain',
        'updated_by'
    ];

    public function searchableAs()
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        return [
            'name'=>$this->name,
            'description'=>$this->description
        ];
    }

    public static $path = 'uploads/products';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function colors(){
        return $this->belongsToMany(Color::class,'product_colors','product_id');
    }

    public function sizes(){
        return $this->belongsToMany(Size::class,'product_sizes','product_id');
    }

    public function rates(){
        return $this->hasMany(Rate::class);
    }

    public function wishLists(){
        return $this->belongsToMany(WishList::class,'wish-list-items','product_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'order_items','product_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

}
