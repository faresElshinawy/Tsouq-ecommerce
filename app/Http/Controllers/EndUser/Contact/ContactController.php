<?php

namespace App\Http\Controllers\EndUser\Contact;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EndUser\Contact\ContactStoreRequest;
use App\Traits\Api;

class ContactController extends Controller
{

    use Api;

    public function index()
    {
        return view('endUser.pages.contact.index');
    }


    public function store(Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $subject = $request->get('subject');
        $message = $request->get('message');
        $validator = Validator::make([
            'name'=>$name,
            'email'=>$email,
            'subject'=>$subject,
            'message'=>$message
        ],[
            'name'=>'required|min:3|max:255',
            'email'=>'required|email',
            'subject'=>'required|min:3|max:255',
            'message'=>"required|min:15|max:500"
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation error',null,$validator->errors(),400);
        }

        $feedback = Feedback::create([
            'name'=>$name,
            'email'=>$email,
            'subject'=>$subject,
            'message'=>$message
        ]);




        return $this->apiResponse('thanks for your feedback');

    }
}
