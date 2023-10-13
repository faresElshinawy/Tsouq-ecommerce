<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Providers\PayPalServiceProvider;

trait PaymentHandler
{

    protected $paypalService;

    public function __construct(ExpressCheckout $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function processRefund(Request $request, Order $order)
    {
        $transactionId = $order->transactionId;
        $refundAmount = $request->get('total_amount');

        $response = $this->paypalService->refundTransaction($transactionId, $refundAmount);
        dd($response);
        if (is_array($response) && array_key_exists('refund_status', $response)) {

            if ($response['refund_status'] === 'refunded') {
                return true;
            }
        }

        return false;
    }
}
