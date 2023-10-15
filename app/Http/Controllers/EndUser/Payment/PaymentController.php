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
use App\Events\OrderSubmited as EventsOrderSubmited;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Requests\Checkout\PaymentRequest;

class PaymentController extends Controller
{
    public function index(Order $order)
    {
        $user_id = auth()->user()->id;
        $subTotal = CartExtra::calcSubTotal($order->items);
        $total = CartExtra::calcTotal($order->items);
        return view('endUser.pages.checkout.index', [
            'order' => $order,
            'countries' => Country::get(),
            'user_addresses' => Address::with('country')->where('user_id', $user_id)->get(),
            'subTotal' => $subTotal,
            'total' => $total + Setting::get('tax'),
            // 'discount'=>number_format(($subTotal - $total) + Setting::get('tax')),
            'first_address' => Address::with('country')->where('user_id', $user_id)->first()
        ]);
    }

    public function payment(PaymentRequest $request, Order $order)
    {
        $discount = 0;
        $tax = Setting::get('tax');
        $total = CartExtra::calcTotal($order->items) + $tax;
        $address_id = $request->address_id;
        $order->address_id = $address_id;
        $order->save();


        if (Session::has('voucher')) {
            $voucher = Session::get('voucher');
            $voucherDiscount = $voucher['discount_value'];
            $total -= $voucherDiscount;
        }

        Session::put('order_info',[
            'order_id'=>$order->id,
            'total'=>$order->total
        ]);


        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $data = json_decode('{
            "intent": "CAPTURE",
            "detail": {
                    "invoice_number": "'.$order->order_serial_code.'",
                    "reference": "deal-ref",
                    "invoice_date": "'. date('Y-m-d') .'",
                    "currency_code": "USD",
                    "note": "Thank you for your purchase.",
                    "term": "No refunds after 30 days.",
                    "memo": "This is a long contract",
                    "payment_term": {
                        "term_type": "NET_10",
                        "due_date": "2018-11-22"
                    }
                },

            "purchase_units": [
                {
                    "amount": {
                        "currency_code": "USD",
                        "value": ' . $total . '
                    }
                }
            ],

            "application_context": {
                "brand_name": "Tsouq",
                "return_url": "' . route('checkout.success') . '",
                "cancel_url": "' . route('checkout.cancel') . '"
            }
        }', true);

        $response = $provider->createOrder($data);

        if(isset($response['id']) && $response['id'] != null){

            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('checkout.cancel');
        }



    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        if(!Session::has('order_info')){
            return redirect()->route('shop.show')->with('error','something went wrong we could not finish your purchase!');
        }
        $response = $provider->capturePaymentOrder($request->token);
        $order_info = Session::get('order_info');
        $order = Order::with('items')->where('id',$order_info['order_id'])->first();
        if(isset($response['status']) && $response['status'] == 'COMPLETED'){
                $transactionId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;
                $order->status = 'in_progress';
                $order->transactionId = $transactionId;
                $order->total_price = $order_info['total'];
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
                Session::forget('order_info');
                Session::flash('success', 'paid successfully for order #' . $order->order_serial_code);
                event(new OrderPlaced($order));
                return redirect()->route('shop.show');
        }
        Session::flash('error', 'payment failed for this order');
        return redirect()->route('checkout.show', ['order' => $order->id]);
    }

    public function cancel(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        if(!Session::has('order_info')){
            return redirect()->route('shop.show')->with('error','purchase canceled!');
        }
        $order_info = Session::get('order_info');
        Session::forget('order_info');
        $order = Order::with('items')->where('id',$order_info['order_id'])->first();
        Session::flash('error', 'paid cancel for order ');
        return redirect()->route('checkout.show', ['order' => $order->id]);
    }
}
