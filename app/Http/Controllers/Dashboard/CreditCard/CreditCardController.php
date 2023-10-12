<?php

namespace App\Http\Controllers\Dashboard\CreditCard;

use App\Models\User;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreditCardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user creditcard', ['only' => ['index','search']]);
        // $this->middleware('permission:creditcard create', ['only' => ['create','store']]);
        // $this->middleware('permission:creditcard edit', ['only' => ['edit','update']]);
        $this->middleware('permission:creditcard delete', ['only' => ['destroy']]);
    }


    public function index(User $user){
        return view('dashboard.pages.users.credit-cards.index',[
            'creditcards'=>CreditCard::where('user_id',$user->id)->paginate(15),
            'user'=>$user
        ]);
    }

    public function search(Request $request,User $user){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $creditcards = CreditCard::query()->where('user_id',$user->id)->where('holder_name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.users.credit-cards.credit-cards-search',[
                'creditcards'=>$creditcards
            ]);
        }
    }

    public function destroy(CreditCard $creditcard){

        $creditcard->delete();

        return redirect()->back()->with('success','creditcard Deleted Successfully');
    }
}
