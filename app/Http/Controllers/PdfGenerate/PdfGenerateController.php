<?php

namespace App\Http\Controllers\PdfGenerate;


use App\Models\Order;
use App\Models\Address;
use Barryvdh\DomPDF\PDF;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PdfGenerateController extends Controller
{


    public function index(Order $order)
    {
        $address = Address::where('id', $order->address_id)->with('country:name,id', 'city:name,id')->first();
        $orderItems = OrderItem::query()->where('order_id', $order->id)->get();

        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('order-pdf.index', [
            'order' => $order,
            'address'=>$address,
            'orderitems'=>$orderItems
        ])->setOptions(['defaultFont' => 'sans-serif']);

        $pdfContent = $pdf->output();

        $response = response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $order->order_serial_code . '.pdf"');

        return $response;
    }



}
