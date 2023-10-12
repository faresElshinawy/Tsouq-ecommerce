<?php

namespace App\Http\Controllers\Dashboard\Feedback;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:feedbacks all', ['only' => ['index','search']]);
        // $this->middleware('permission:feedbacks create', ['only' => ['create','store']]);
        // $this->middleware('permission:feedbacks edit', ['only' => ['edit','update']]);
        $this->middleware('permission:feedbacks delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.feedbacks.index',[
            'feedbacks'=>Feedback::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $feedbacks = Feedback::query()->orWhere('name','like',"%{$query}%")->orWhere('subject','like',"%{$query}%")->orWhere('email','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.feedbacks.feedback-search',[
                'feedbacks'=>$feedbacks
            ]);
        }
    }


    public function destroy(Feedback $feedback){
        $feedback->delete();
        return redirect()->back()->with('success','feedback Deleted Successfully');
    }
}
