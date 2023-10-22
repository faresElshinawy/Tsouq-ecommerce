<?php

namespace App\Observers;

use App\Models\user;
use App\Models\WishList;
use App\Events\UserRegistration;
use Illuminate\Support\Facades\Cache;

class UserObserver
{

    public function created(user $user): void
    {
        WishList::create([
            'user_id'=>$user->id,
            'name'=>'defualt'
        ]);
        event(new UserRegistration($user));
    }

    public function updated(user $user): void
    {
        Cache::clear();
    }
}
