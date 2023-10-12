<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Traits\Api;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{

    use UploadFile;


    public function __construct()
    {
        $this->middleware('permission:user all', ['only' => ['index','search']]);
        $this->middleware('permission:user create', ['only' => ['create','store']]);
        $this->middleware('permission:user edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user delete', ['only' => ['destroy']]);
    }

    public function index(Request $request){

        $users = User::query();

        return view('dashboard.pages.users.index',[
            'users'=>$users->paginate(15)
        ]);
    }

    public function search(Request $request){

        if($request->ajax())
        {
            $users = User::query();
            $query = trim($request->get('query'));
            $users->where('name','like',"%{$query}%")->orWhere('email','like',"%{$query}%");
            return view('dashboard.pages.users.user-search',['users'=>$users->paginate(15)]);
        }
    }

    public function create(){
        return view('dashboard.pages.users.create',[
            'roles'=>Role::get()
        ]);
    }

    public function store(UserStoreRequest $request){
        $user = User::create([
                'name'=>trim($request->name),
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'roles_name'=>$request->roles,
                'image'=>$this->newImage(User::$path,$request)
            ]);

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect()->back()->with('success','User Created Successfully');
    }

    public function edit(User $user){
        DB::table('notifications')->where('notifiable_id',Auth::user()->id)->where('data->user_id',$user->id)->where('data->notify_type','user')->update([
            'read_at'=>now()
        ]);
        return view('dashboard.pages.users.edit',[
            'user'=>$user,
            'roles'=>Role::get()
        ]);
    }

    public function update(UserUpdateRequest $request,User $user){
        $user->update([
            'name'=>trim($request->name),
            'email'=>$request->email,
            'password'=>($request->password ? Hash::make($request->password) : $user->password),
            'roles_name'=>$request->roles,
            'image'=>$this->newImage(User::$path,$request,$user->image)
        ]);


        foreach($user->roles as $role){
            $user->removeRole($role);
        }

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect()->back()->with('success','User Updated Successfully');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->back()->with('success','User Deleted Successfully');
    }
}
