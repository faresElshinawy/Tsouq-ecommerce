@extends('dashboard.layouts.master')


@section('content')
<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit voucher</h5>
      </div>
      <div class="card-body">
        <form action='{{route('vouchers.update',['voucher'=>$voucher->id])}}' method="POST">
            @csrf
            @method('put')
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-code">code</label>
            <div class="col-sm-10">
              <input type="text" value='{{old('code') ?? $voucher->code }}' class="form-control  @error('code') border-danger @enderror" id="basic-default-code" name="code" placeholder="Voucher Code">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-value">value</label>
            <div class="col-sm-10">
              <input type="number" value='{{old('value') ?? $voucher->value}}' class="form-control  @error('value') border-danger @enderror" id="basic-default-value" name="value" placeholder="Voucher Value">
            </div>
          </div>



          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-price_limit">Price Limit</label>
            <div class="col-sm-10">
              <input type="number" value='{{old('price_limit') ?? $voucher->price_limit }}' class="form-control  @error('price_limit') border-danger @enderror" id="basic-default-price_limit" name="price_limit" placeholder="Price Limit">
            </div>
          </div>


          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-type">type</label>
            <div class="col-sm-10">
                <select name="type" class="form-control @error('type') border-danger @enderror" id="basic-default-type">
                    <option selected disabled>select voucher type</option>
                    @foreach ($types as $type)
                    <option value="{{str_replace(' ','_',$type)}}" @selected($type == old('type') || $type == $voucher->type)>{{$type}}</option>
                    @endforeach
                </select>
                <span class="text-muted">percentage & row discounts will effect the order price in different ways so be carefull about the voucher type you want.</span>
            </div>
          </div>


          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-status">status</label>
            <div class="col-sm-10">
                <select name="status" class="form-control @error('status') border-danger @enderror" id="basic-default-status">
                    <option selected disabled>select voucher type</option>
                    @foreach ($status as $status_opt)
                    <option value="{{$status_opt}}" @selected($status_opt == old('status') ||$status_opt == $voucher->status)>{{$status_opt}}</option>
                    @endforeach
                </select>
            </div>
          </div>





          <div class="row justify-content-end">
            <div class="col-sm-10 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Send</button>
                <a href="{{ route('vouchers.all') }}" class="btn btn-secondary">back</a>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
