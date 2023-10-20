<?php

namespace App\Observers;

use App\Models\Order;
use App\Mail\OrderStatus;
use App\Jobs\SendOrderMailJob;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Mail::to('faresleshinawy560@gmail.com')->send(new OrderStatus($order));
        SendOrderMailJob::dispatch($order)->onConnection('database');
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Mail::to('faresleshinawy560@gmail.com')->send(new OrderStatus($order));
        SendOrderMailJob::dispatch($order)->onConnection('database');

    }

    // /**
    //  * Handle the Order "deleted" event.
    //  */
    // public function deleted(Order $order): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Order "restored" event.
    //  */
    // public function restored(Order $order): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Order "force deleted" event.
    //  */
    // public function forceDeleted(Order $order): void
    // {
    //     //
    // }
}
