<?php

namespace App\Http\Controllers\EndUser\ChatMessage;

use Carbon\Carbon;
use App\Traits\Api;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Events\ChatNewMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatMessageController extends Controller
{

    use Api;

    public function store(Request $request){
        if($request->ajax()){
            $message = $request->get('message');
            $chat_id = $request->get('chat_id');
            $validator = Validator::make([
                'message'=>$message
            ],[
                'message'=>'required'
            ]);

            if($validator->fails()){
                return $this->apiResponse('your message cant be null',null,null,204);
            }

            $message = ChatMessage::create([
                'message'=>$message,
                'sender'=>Auth::user()->id,
                'chat_id'=>$chat_id
            ]);

            $message->time = Carbon::parse($message->created_at)->format('h:i A, F jS');


            if($message){
                event(new ChatNewMessageEvent($message,$request));
                return $this->apiResponse('success',$message);
            }

        }
    }




}
