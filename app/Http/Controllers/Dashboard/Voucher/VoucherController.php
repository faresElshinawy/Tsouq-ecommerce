<?php

namespace App\Http\Controllers\Dashboard\Voucher;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\VoucherStoreRequest;
use App\Http\Requests\Voucher\VoucherUpdateRequest;

class VoucherController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:voucher all', ['only' => ['index','search']]);
        $this->middleware('permission:voucher create', ['only' => ['create','store']]);
        $this->middleware('permission:voucher edit', ['only' => ['edit','update']]);
        $this->middleware('permission:voucher delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.vouchers.index',[
            'vouchers'=>Voucher::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $vouchers = Voucher::query()->where('code','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.vouchers.voucher-search',[
                'vouchers'=>$vouchers
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.vouchers.create',[
            'types'=>['percentage','row discount'],
            'status'=>['active','inactive']
        ]);
    }

    public function store(VoucherStoreRequest $request){
        Voucher::create([
            'code'=>$request->code,
            'value'=>$request->value,
            'price_limit'=>$request->price_limit,
            'type'=>$request->type,
            'status'=>$request->status
        ]);
        return redirect()->back()->with('success','voucher Created Successfully');
    }

    public function edit(Voucher $voucher){
        return view('dashboard.pages.vouchers.edit',[
            'voucher'=>$voucher,
            'types'=>['percentage','row discount'],
            'status'=>['active','inactive']
        ]);
    }

    public function update(VoucherUpdateRequest $request,Voucher $voucher){
        $voucher->update([
            'code'=>$request->code,
            'value'=>$request->value ?? 0,
            'price_limit'=>$request->price_limit,
            'type'=>$request->type,
            'status'=>$request->status
        ]);
        return redirect()->back()->with('success','voucher Updated Successfully');
    }

    public function destroy(Voucher $voucher){
        $voucher->delete();
        return redirect()->back()->with('success','voucher Deleted Successfully');
    }
}
