<?php

namespace App\Http\Controllers\EndUser\Subscribe;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SubscribeStoreRequest;
use App\Traits\Api;

class SubscribeController extends Controller
{

    use Api;

    public function store(Request $request){

        $name = $request->get('name');
        $email = $request->get('email');
        $validator = Validator::make([
            $name != null ? "'name'=>$name" : null,
            'email'=>$email
        ],[
            'name'=>'min:3|max:255',
            'email'=>'required|email|unique:subscribers,email'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errors(),400);
        }

        $subscribe = Subscriber::create([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        if($subscribe){
            return $this->apiResponse('subscribed successfully');
        }
    }
}
