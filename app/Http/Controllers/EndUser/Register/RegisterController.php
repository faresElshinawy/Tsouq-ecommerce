<?php

namespace App\Http\Controllers\EndUser\Register;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Notifications\NewUser;
use App\Events\UserRegistration;
use App\Events\UserRegisteration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{
        /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('endUser.pages.register.index');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'max:20','min:8','regex:/[a-z]/','regex:/[A-Z]/','regex:/[1-10]/'],
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles_name'=>['user']
        ]);


        Session::flash('success','Account Created Successfully');

        return redirect()->route('user-login.create');
    }
}
