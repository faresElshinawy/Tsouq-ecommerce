<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

trait PaymentHandler
{

    public function processRefund(Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $transactionId = $order->transactionId;
        $refundAmount = request()->get('total_amount');
        $refundReason = request()->get('refund_reason');
        $response = $provider->refundCapturedPayment(
            $transactionId,
            $order->order_serial_code,
            $refundAmount,
            $refundReason
        );


        if (is_array($response) && array_key_exists('status', $response)) {

            if ($response['status'] === 'COMPLETED') {
                return 'COMPLETED';
            }
        }

        if(is_array($response) && array_key_exists('error', $response)){
            $issue = $response['error']['details'][0]['description'] ?? null;
            return $issue;
        }
    }
}
