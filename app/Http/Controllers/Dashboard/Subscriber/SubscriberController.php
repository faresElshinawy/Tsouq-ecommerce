<?php

namespace App\Http\Controllers\Dashboard\Subscriber;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:subscriber all', ['only' => ['index','search']]);
        $this->middleware('permission:subscriber delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.subscribers.index',[
            'subscribers'=>Subscriber::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $subscribers = Subscriber::query()->where('name','like',"%{$query}%")->orWhere('email','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.subscribers.subscriber-search',[
                'subscribers'=>$subscribers
            ]);
        }
    }

    public function destroy(Subscriber $subscriber){
        $subscriber->delete();
        return redirect()->back()->with('success','subscriber Deleted Successfully');
    }
}
