<?php

namespace App\Http\Controllers\EndUser\Profile;

use App\Models\User;
use Illuminate\View\View;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EndUser\Profile\ProfileUpdateRequest;
use App\Http\Requests\EndUser\Profile\UserImageUpdateRequest;
use App\Http\Requests\Profile\ProfileDeleteRequest;

class ProfileController extends Controller
{
    use UploadFile;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('endUser.pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password ? Hash::make($request->password) : auth()->user()->password
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if($request->file('image')){
            $request->user()->image = $this->newImage(User::$path,$request,$request->user()->image);
        }

        $request->user()->save();

        toast('profile updated successfully','success');

        return Redirect::route('end-user.profile.edit');
    }


    public function updateImage(UserImageUpdateRequest $request){
        if($request->file('image')){
            $status = ($request->user()->image = $this->newImage(User::$path,$request,$request->user()->image,$request->user()->image));
            $request->user()->save();

            if($status){
                toast('Image Updated successfully','success');
            }else{
                toast('there is a problem could not update your image please try again later','error');
            }

        }


        return redirect()->back();


    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('Your account has been deleted hope you will join us again','success');

        return Redirect::route('user-register.create');
    }
}
