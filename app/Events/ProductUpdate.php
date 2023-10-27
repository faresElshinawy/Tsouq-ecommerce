<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Notifications\ProductUpdate as UpdateProduct;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    private $created_at;
    /**
     * Create a new event instance.
     */
    public function __construct(Product $product)
    {
        $user = Auth::user();
        $this->created_at = now()->format('Y-m-d H:i:s');
        $this->data = [
            'username'=>$user->name,
            'user_id'=>$user->id,
            'notify_type'=>'product',
            'product_id'=>$product->id,
            'product_name'=>$product->name,
            'action'=>'updated',
            'created_at'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
        $users = User::where('id','!=',$user->id)->permission('notify')->get();
        Notification::send($users,new UpdateProduct($product,$this->created_at));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('product-channel'),
        ];
    }

    public function broadcastAs(){
        return 'product-update';
    }
}
