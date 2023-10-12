@extends('dashboard.layouts.master')


@section('content')
<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit size</h5>
      </div>
      <div class="card-body">
        <form action='{{route('sizes.update',['size'=>$size->id])}}' method="POST">
            @csrf
            @method('put')
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
            <div class="col-sm-10">
              <input type="text" value='{{old('name') ?? $size->name}}' class="form-control  @error('name') border-danger @enderror" id="basic-default-name" name="name" placeholder="Name">
            </div>
          </div>





          <div class="row justify-content-end">
            <div class="col-sm-10 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Send</button>
                <a href="{{ route('sizes.all') }}" class="btn btn-secondary">back</a>
            </div>
        </div>
        </form>
      </div>
    </div>
</div>
@endsection
