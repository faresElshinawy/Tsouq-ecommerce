<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Notifications\OrderSubmited;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $created_at;
    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->created_at = now()->format('Y-m-d H:i:s');
        $this->data = [
            'username'=>Auth::user()->name,
            'user_id'=>Auth::user()->id,
            'order_id'=>$order->id,
            'notify_type'=>'order',
            'order_code'=>$order->order_serial_code,
            'action'=>'placed',
            'created_at'=>Carbon::parse($this->created_at)->diffForHumans()
        ];

        $users = User::where('id','!=',Auth::user()->id)->permission('notify')->get();
        Notification::send($users,new OrderSubmited($order,$this->created_at));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order-channel'),
        ];
    }

    public function broadcastAs(){
        return 'order-event';
    }
}
