<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductUpdate extends Notification implements ShouldBroadcast
{
    use Queueable;
    private $product;
    private $created_at;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product,$created_at)
    {
        $this->product = $product;
        $this->created_at = $created_at;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id'=>$this->product->id,
            'notify_type'=>'product',
            'product_name'=>$this->product->name,
            'action'=>'updated',
            'username'=>Auth::user()->name,
            'created_at'=>$this->created_at
        ];
    }
}
