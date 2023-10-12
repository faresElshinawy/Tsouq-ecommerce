<?php

namespace App\Http\Controllers\EndUser\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    /**
     * Display the login view.
     */
    public function create(){
        return view('endUser.pages.login.index');
    }

        /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();


        $request->session()->regenerate();

        $request->user()->status = 'online';
        $request->user()->save();

        Session::flash('success','signed in succesfully');

        return redirect()->route('home.show');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->status = 'offline';
        $request->user()->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Session::flash('success','signed out succesfully');


        return redirect()->route('user-login.create');
    }
}
