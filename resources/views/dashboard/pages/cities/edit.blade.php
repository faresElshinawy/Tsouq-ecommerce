@extends('dashboard.layouts.master')


@section('content')
<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit city</h5>
      </div>
      <div class="card-body">
        <form action='{{route('cities.update',['city'=>$city->id])}}' method="POST">
            @csrf
            @method('put')
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
            <div class="col-sm-10">
              <input type="text" value='{{old('name') ?? $city->name}}' class="form-control  @error('name') border-danger @enderror" id="basic-default-name" name="name" placeholder="Name">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Country</label>
            <div class="col-sm-10">
                <select name="country_id" class="form-control @error('country') border-danger @enderror">
                    <option selected disabled>select country</option>
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}" @selected(old('country_id') == $country->id || $country->id == $city->country_id)>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-sm-10 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Send</button>
                <a href="{{ route('cities.all') }}" class="btn btn-secondary">back</a>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
