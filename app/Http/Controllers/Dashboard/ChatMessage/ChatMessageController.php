<?php

namespace App\Http\Controllers\Dashboard\ChatMessage;

use Carbon\Carbon;
use App\Traits\Api;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ChatNewMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatMessageController extends Controller
{

    use Api;

    public function __construct()
    {
        $this->middleware('can:customer service');
    }


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

            if($message){
                $message->time = Carbon::parse($message->created_at)->format('h:i A, F jS');
                event(new ChatNewMessageEvent($message,$request));
                return $this->apiResponse('success',$message);
            }
        }
    }

    public function changeMessagesStatus(Request $request){
        if($request->ajax()){
            $chat_id = $request->get('chat_id');
            $chat = Chat::where('id',$chat_id)->first();
            ChatMessage::where('chat_id',$chat->id)->where('sender',$chat->user->id)->where('status','0')->update([
                'status'=>'1'
            ]);
            return $this->apiResponse('success');
        }
    }

}
