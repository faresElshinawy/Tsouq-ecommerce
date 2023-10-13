@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Set Refund Order : <span class="text-muted">{{$order->order_serial_code}}</span></h5>
            </div>
            <div class="card-body">
                <form action='{{ route('orders-refunds.store',['order'=>$order->id]) }}' method="POST" >
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-refund_reason">Refund Reason</label>
                        <div class="col-sm-10">
                            <textarea name="refund_reason" class="form-control" id="" cols="30" rows="5" placeholder="Please Enter The Reason For This Refund">{{old('refund_reason')}}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-total_amount">Total Amount</label>
                        <div class="col-sm-10">
                            <input type="text" value='{{ old('total_amount') }}'
                                class="form-control  @error('total_amount') border-danger @enderror" id="basic-default-total_amount"
                                name="total_amount" placeholder="Total Amount">
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ route('orders-refunds.all') }}" class="btn btn-secondary">back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
