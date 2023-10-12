<?php

namespace App\Observers;

use App\Models\user;
use App\Models\WishList;

class UserObserver
{
    // /**
    //  * Handle the user "created" event.
    //  */
    public function created(user $user): void
    {
        WishList::create([
            'user_id'=>$user->id,
            'name'=>'defualt'
        ]);
    }

    /**
     * Handle the user "updated" event.
     */
    // public function updated(user $user): void
    // {
    //     //
    // }

    // /**
    //  * Handle the user "deleted" event.
    //  */
    // public function deleted(user $user): void
    // {
    //     //
    // }

    // /**
    //  * Handle the user "restored" event.
    //  */
    // public function restored(user $user): void
    // {
    //     //
    // }

    // /**
    //  * Handle the user "force deleted" event.
    //  */
    // public function forceDeleted(user $user): void
    // {
    //     //
    // }
}
