<?php

namespace App\Http\Controllers\Dashboard\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\Api;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    use Api;

    public function __construct()
    {
        $this->middleware('permission:notification access');
    }

    public function index(){

        $notifications = Auth::user()->notifications()->paginate();
        return view('dashboard.pages.notification.index',[
            'notifications'=>$notifications
        ]);
    }


    public function destroy(Notification $notification){
            $notification->delete();
            return redirect()->back()->with('success','Notification Deleted Successfully');
    }


    public function readAll(){
        Auth::user()->unreadNotifications->markAsRead();
        return $this->apiResponse('All Notifications Marked As read');
    }


    public function destroyAll(Request $request){
        $request->user()->notifications()->delete();
        return $this->apiResponse('All Notificatinos Deleted Successfully');
    }
}
