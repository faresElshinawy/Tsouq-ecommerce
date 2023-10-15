<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'refundable_id',
        'refundable_type',
        'quantity',
        'total_amount',
        'refund_reason',
        'transaction_id'
    ];


    public function refundable(){
        return $this->morphTo();
    }
}
