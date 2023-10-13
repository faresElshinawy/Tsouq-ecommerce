<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'order_serial_code',
        'user_id',
        'address_id',
        'status',
        'total_price'
    ];

    public function refunds(){
        return $this->morphMany(Refund::class,'refundable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id');
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }


}
