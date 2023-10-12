<?php

namespace App\Http\Controllers\EndUser\Chat;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Traits\Api;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use Api;
    
    public function index(Request $request)
    {
        $chat = Chat::with('user:id,name')->where('user_id', Auth::id())->first();
        if (!$chat) {
            $chat = Chat::create([
                'user_id' => Auth::id()
            ]);
        }
        $messages = ChatMessage::where('chat_id', $chat->id)->paginate();
        if ($request->ajax()) {
            $view = view('endUser.pages.chat.load-messages', [
                'messages' => $messages,
                'chat' => $chat,
                ])->render();
            return $this->apiResponse('success',[
                'view'=>$view,
                'nextPage'=> $messages->lastPage() == $messages->currentPage() ? 'no more messages'  : $messages->nextPageUrl()
            ]);
        }
        return view('endUser.pages.chat.index', [
            'chat' => $chat,
            'messages' => $messages
        ]);
    }

}
