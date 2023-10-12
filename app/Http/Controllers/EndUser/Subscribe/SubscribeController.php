<?php

namespace App\Http\Controllers\EndUser\Subscribe;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeStoreRequest;

class SubscribeController extends Controller
{
    public function store(SubscribeStoreRequest $request){
        $subscribe = Subscriber::create([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        if($subscribe){
            toast('subscribed successfully','success');
        }else{
            toast('could not subscribe please try again later','error');
        }

        return redirect()->back();
    }
}
