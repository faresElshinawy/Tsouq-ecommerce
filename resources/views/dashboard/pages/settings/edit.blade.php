@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit setting</h5>
            </div>
            <div class="card-body">
                <form action='{{ route('settings.update', ['setting' => $setting->id]) }}' method="POST" enctype='multipart/form-data'>
                    @csrf
                    @method('put')


                    @if ($setting->key == 'slider-one-image' || $setting->key == 'slider-two-image')
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('uploads/settings/' . $setting->value) }}"
                                class="w-px-400 my-3  h-auto rounded-square img-fluid" alt="">
                        </div>
                    @endif



                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-value">{{ $setting->key }}</label>
                        <div class="col-sm-10">
                            @if ($setting->key == 'slider-one-image' || $setting->key == 'slider-two-image')
                                <input type="file" value='{{ old('image') }}'
                                    class="form-control  @error('image') border-danger @enderror" id="basic-default-image"
                                    name="image">
                            @elseif($setting->key == 'slider-type')
                                <select name="type" class="form-control">
                                    <option selected disabled>Select Slider type</option>
                                    <option value="static" @selected(old('type') == 'static' || $setting->value == 'static')>static</option>
                                    <option value="dynamic" @selected(old('type') == 'dynamic' || $setting->value == 'dynamic')>dynamic</option>
                                </select>
                            @else
                                <input type="text" value='{{ old('value') ?? $setting->value }}'
                                    class="form-control  @error('value') border-danger @enderror" id="basic-default-value"
                                    name='value' placeholder="value">
                            @endif
                        </div>
                    </div>




                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ route('settings.all') }}" class="btn btn-secondary">back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
