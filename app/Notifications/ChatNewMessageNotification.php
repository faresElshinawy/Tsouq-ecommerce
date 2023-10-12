<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChatNewMessageNotification extends Notification
{
    use Queueable;
    protected $message;
    protected $time;
    /**
     * Create a new notification instance.
     */
    public function __construct(ChatMessage $message,$time)
    {
        $this->message = $message;
        $this->time = $time;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'username'=>Auth::user()->name,
            'chat_id'=>$this->message->chat_id,
            'notify_type'=>'chat',
            'message'=>$this->message->message,
            'time'=>$this->time,
            'created_at'=>$this->message->created_at
        ];
    }
}
