<?php

namespace App\Http\Controllers\EndUser\Social;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    public function handleCallback(){
        try{
            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id',$user->id)->first();

            if($finduser){
                $finduser->status = 'online';
                $finduser->save();
                Auth::login($finduser);
                Session::flash('success','signed in successfully');
                return redirect()->route('shop.show');
            }
            $userExists = User::where('email',$user->email)->first();
            if($userExists){
                Session::flash('error','Your email is a duplicate we could not make this action');

                return redirect()->back();
            }
            $newuser = User::create([
                'name'=>$user->name,
                'email'=>$user->email,
                'status'=>'online',
                'social_id'=>$user->id,
                'social_type'=>'google',
                'password'=>Hash::make('my-google')
            ]);
            Auth::login($newuser);
            Session::flash('success','signed in successfully');
            return redirect()->route('shop.show');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
