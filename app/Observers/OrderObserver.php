<?php

namespace App\Observers;

use App\Models\Order;
use App\Mail\OrderStatus;
use App\Jobs\SendOrderMailJob;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{

    public function created(Order $order): void
    {
        // Mail::to('faresleshinawy560@gmail.com')->send(new OrderStatus($order));
        SendOrderMailJob::dispatch($order)->onConnection('database');
    }


    public function updated(Order $order): void
    {
        // Mail::to('faresleshinawy560@gmail.com')->send(new OrderStatus($order));
        SendOrderMailJob::dispatch($order)->onConnection('database');

    }
}
