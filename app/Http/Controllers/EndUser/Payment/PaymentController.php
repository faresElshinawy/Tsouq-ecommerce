<?php

namespace App\Http\Controllers\EndUser\Payment;

use App\Models\Order;
use App\Models\Address;
use App\Models\Country;
use App\Traits\CartExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use anlutro\LaravelSettings\Facades\Setting;
use App\Events\OrderPlaced;
use App\Events\OrderShipped;
use App\Events\OrderSubmited as EventsOrderSubmited;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Http\Requests\Checkout\PaymentRequest;

class PaymentController extends Controller
{
    public function index(Order $order){
        $user_id = auth()->user()->id;
        $subTotal = CartExtra::calcSubTotal($order->items);
        $total = CartExtra::calcTotal($order->items);
        return view('endUser.pages.checkout.index',[
            'order'=>$order,
            'countries'=>Country::get(),
            'user_addresses'=>Address::with('country')->where('user_id',$user_id)->get(),
            'subTotal'=>$subTotal,
            'total'=> $total + Setting::get('tax'),
            // 'discount'=>number_format(($subTotal - $total) + Setting::get('tax')),
            'first_address'=>Address::with('country')->where('user_id',$user_id)->first()
        ]);
    }

    public function payment(PaymentRequest $request, Order $order)
    {
        $data = [];
        $items = [];
        $discount = 0;
        $tax = Setting::get('tax');
        $total = $tax;
        $address = $request->address_id;
        $order->address_id = $address;
        $order->save();

        foreach ($order->items as $item) {
            $itemPrice = round($item->product->price - (($item->product->discount / 100) * $item->product->price));
            for ($i=1; $i <= $item->quantity ; $i++) {
                $items[] = [
                    'name' => $item->product->name,
                    'price' => $itemPrice,
                    'desc' => $item->product->description,
                    'qty' => 1,
                ];
            }
            $total += $itemPrice * $item->quantity;
        }


        $items[] = [
            'name'=>'deliver tax',
            'price'=>$tax,
            'desc'=>"deliver tax for order #{$order->order_serial_code}",
            'qty'=>1
        ];

        if (Session::has('voucher')) {
            $voucher = Session::get('voucher');
            $voucherDiscount = $voucher['discount_value'];

            // Add voucher discount as a separate line item
            $items[] = [
                'name' => 'Voucher Discount',
                'price' => -$voucherDiscount,
                'desc' => "Voucher Discount - #{$voucher['voucher_code']}",
                'qty' => 1,
            ];

            $discount = $voucherDiscount;
            $total -= $discount;
        }



        $data['items'] = $items;
        $data['invoice_id'] = $order->order_serial_code;
        $data['invoice_description'] = "Order Serial Code #{$data['invoice_id']}";
        $data['return_url'] = "http://127.0.0.1:8000/checkout/payment/success";
        $data['cancel_url'] = "http://127.0.0.1:8000/checkout/payment/cancel";
        $data['total'] = $total;

        $provider = new ExpressCheckout;
        $options = [
            'BRANDNAME' => 'Tsouq',
            'CHANNELTYPE' => 'Merchant'
        ];
        $response = $provider->addOptions($options)->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
    }

    public function success(Request $request){
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        $order_serial_code = $response['INVNUM'];
        $order = explode('-',$order_serial_code);
        $order = Order::with('items')->where('id',$order[2])->first();
        if(in_array(strtoupper($response['ACK']),['SUCCESS','SUCCESSWITHWARNING'])){

            event(new OrderPlaced($order));

            $order->status = 'in_progress';
            $order->total_price = $response['AMT'] - Setting::get('tax');
            $order->transactionId =  $response['TOKEN'];
            $order->save();
            foreach ($order->items as $item) {
                $itemPrice = round($item->product->price - (($item->product->discount / 100) * $item->product->price));
                $item->price = $item->product->price;
                $item->final_price = $itemPrice;
                $item->discount = $item->product->discount;
                $item->discount_value = ($item->product->discount / 100) * $item->product->price;
                $item->save();
                $item->product->count -= $item->quantity;
                $item->product->solded_out += $item->quantity;
                $item->product->save();
            }
            Session::forget('voucher');
            Session::flash('success','paid successfully for order #'. $order_serial_code);
            return redirect()->route('shop.show');
        }


        Session::flash('error','payment failed for this order');
        return redirect()->route('checkout.show',['order'=>$order->id]);
    }

    public function cancel(Request $request){
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        $order_serial_code = $response['INVNUM'];
        $order = explode('-',$order_serial_code);
        $order = Order::where('id',$order[2])->first();
        Session::flash('success','paid cancel for order ');
        return redirect()->route('checkout.show',['order'=>$order->id]);
    }
}
