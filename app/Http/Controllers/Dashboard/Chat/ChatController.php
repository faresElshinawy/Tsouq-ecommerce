<?php

namespace App\Http\Controllers\Dashboard\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Api;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use Api;

    public function __construct()
    {
        $this->middleware('can:customer service');
    }

    public function index()
    {
        return view('dashboard.pages.chats.index', [
            'chats' => Chat::with('user:id,name', 'messages:id,chat_id,status,sender')->where('user_id', '!=', Auth::id())->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = trim($request->get('query'));

            $chats = Chat::with('user', 'messages:id,chat_id,status,sender')->where('user_id', '!=', Auth::id())->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })->paginate(10);

            return view('dashboard.pages.chats.chat-search', [
                'chats' => $chats
            ]);
        }
    }


    public function show(Request $request,Chat $chat)
    {

        $messages = ChatMessage::where('chat_id', $chat->id)->paginate();
        if ($request->ajax()) {
            $view = view('dashboard.pages.chats.chat-messages.load-messages', [
                'messages' => $messages,
                'chat' => $chat,
                ])->render();
            return $this->apiResponse('success',[
                'view'=>$view,
                'nextPage'=> $messages->lastPage() == $messages->currentPage() ? 'no more messages'  : $messages->nextPageUrl()
            ]);
        }

        ChatMessage::where('chat_id', $chat->id)->where('sender', $chat->user->id)->where('status', '0')->update([
            'status' => '1'
        ]);
        DB::table('notifications')->where('data->chat_id', $chat->id)->where('notifiable_id', Auth::user()->id)->where('data->notify_type', 'chat')->update([
            'read_at' => now()
        ]);
        return view('dashboard.pages.chats.show', [
            'messages' => $messages,
            'chat' => $chat,
        ]);
    }
}
