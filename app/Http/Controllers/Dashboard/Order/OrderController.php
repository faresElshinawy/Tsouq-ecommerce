<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Mail\OrderStatus;
use App\Models\OrderItem;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Jobs\SendOrderMailJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Vonage\Client\Credentials\Basic;
use App\Http\Requests\Order\OrderUpdateRequest;

class OrderController extends Controller
{


public function __construct()
    {
    $this->middleware('permission:user order', ['only' => ['userOrders','userOrdersSearch']]);
    $this->middleware('permission:order all', ['only' => ['index','search']]);
    $this->middleware('permission:order create', ['only' => ['create','store']]);
    $this->middleware('permission:order edit', ['only' => ['edit','update']]);
    $this->middleware('permission:order delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.orders.index',[
            'orders'=>Order::where('status','!=','pending')->with('user','products:price,id')->orderBy('created_at','desc')->paginate()
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $status = $request->get('status');
            $date_from = $request->get('date_from');
            $date_to = $request->get('date_to');
            $orders = Order::query()->where('status','!=','pending')->with('user');

            if($query != null){
                $orders->whereHas('user',function ($result) use ($query) {
                    $result->where('name','like',"%{$query}%");
                })->orWhere('order_serial_code','like',"%{$query}");
            }

            if($status != null){
                $orders->where('status',$status);
            }

            if($date_from != null && $date_to != null){
                $orders->whereBetween('created_at',[$date_from,$date_to]);
            }


            return view('dashboard.pages.orders.order-search',[
                'orders'=>$orders->orderBy('created_at','desc')->paginate()
            ]);
        }
    }

    public function userOrder(User $user){
        return view('dashboard.pages.users.orders.index',[
            'orders'=>Order::where('status','!=','pending')->where('user_id',$user->id)->orderBy('created_at','desc')->paginate(),
            'user'=>$user
        ]);
    }

    public function userOrderSearch(Request $request){
        if($request->ajax()){
            $query = $request->get('query');
            $user_id = $request->get('user_id');
            $orders = Order::where('status','!=','pending')->where('user_id',$user_id)->Where('order_serial_code','like',"%{$query}%")->paginate();
            return view('dashboard.pages.users.orders.order-search',[
                'orders'=>$orders
            ]);
        }
    }

    public function edit(Order $order){

        DB::table('notifications')->where('data->order_id',$order->id)->where('notifiable_id',Auth::user()->id)->where('data->notify_type','order')->update([
            'read_at'=>now()
        ]);
        
        return view('dashboard.pages.orders.edit',[
            'order'=>$order,
            'status'=>['in_progress','shipped','delivered','rejected']
        ]);
    }

    public function update(OrderUpdateRequest $request,Order $order){
        $order->update([
            'status'=>$request->status,
        ]);

        if($request->sms_approved){

            $phone = $order->address->country->code . $order->address->phone;
            $basic  = new \Vonage\Client\Credentials\Basic("20501e3d", "65iDs26Rqacic5xL");
            $client = new \Vonage\Client($basic);

            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS($phone, 'Tsouq', 'Your Order Number #' . $order->order_serial_code . ' is ' . $order->status)
            );

            $message = $response->current();

            if ($message->getStatus() != 0) {
                toast("The message failed with status: " . $message->getStatus() . "\n",'error');
            }
        }
        return redirect()->back()->with('success','order Updated Successfully');

    }

    public function destroy(Order $order){
        $order->delete();
        return redirect()->back()->with('success','order Deleted Successfully');
    }

}
