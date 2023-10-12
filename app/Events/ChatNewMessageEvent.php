<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use App\Notifications\ChatNewMessageNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatNewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $time;
    public $username;
    public $created_at;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $chatMessage,Request $request)
    {
        $this->message = $chatMessage;
        $this->time = Carbon::parse($chatMessage->created_at)->format('h:i A, F jS');
        $this->username = $request->user()->name;
        $this->created_at = Carbon::parse($chatMessage->created_at)->diffForHumans();
        $users = User::where('id','!=',$this->message->sender)->whereJsonContains('roles_name','customer service')->get();
        Notification::send($users,new ChatNewMessageNotification($this->message,$this->time));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat-'.$this->message->chat_id),
            new Channel('chat'),
        ];
    }

    public function broadcastAs(){
        return 'new-message';
    }
}
