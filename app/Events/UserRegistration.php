<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRegistration implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(User $user)
    {


        $this->data = [
            'user_id' => $user->id,
            'notify_type' => 'user',
            'user_name' => 'New Account ' . $user->name,
            'action' => 'created',
            'created_at'=>now()->format('Y-m-d H:i:s')
        ];
        $users = User::where('id','!=',$user->id)->whereJsonContains('roles_name','notify')->get();
        Notification::send($users,new NewUser($user,$this->data['created_at']));
        $this->data['created_at'] = Carbon::parse($this->data['created_at'])->diffForHumans();
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('user-channel'),
        ];
    }

    public function broadcastAs(){
        return 'user-event';
    }
}
