@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">New product</h5>
            </div>
            <div class="card-body">
                <form action='{{ route('products.store') }}' method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" value='{{ old('name') }}'
                                class="form-control  @error('name') border-danger @enderror" id="basic-default-name"
                                name="name" placeholder="Name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-Description">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control  @error('name') border-danger @enderror" id="basic-default-Description"name="description"
                                placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-price">Price</label>
                        <div class="col-sm-10">
                            <input type="number" value='{{ old('price') }}'
                                class="form-control  @error('price') border-danger @enderror" id="basic-default-price"
                                name="price" placeholder="Price">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-count">count</label>
                        <div class="col-sm-10">
                            <input type="number" value='{{ old('count') }}'
                                class="form-control  @error('count') border-danger @enderror" id="basic-default-count"
                                name="count" placeholder="Count">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-discount">discount</label>
                        <div class="col-sm-10">
                            <input type="number" value='{{ old('discount') }}'
                                class="form-control  @error('discount') border-danger @enderror" id="basic-default-discount"
                                name="discount"
                                placeholder="Discount value">
                                <span class="text-muted d-block">note that the values you enter in discount is a precentage values</span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-categore">category</label>
                        <div class="col-sm-10">
                            <select name="category_id" id="basic-default-categore" class="form-control  @error('category_id') border-danger @enderror">
                                <option selected disabled>Select Product Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected( old('category_id') == $category->id )>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-brand">brand</label>
                        <div class="col-sm-10">
                            <select name="brand_id" id="basic-default-brand" class="form-control  @error('brand') border-danger @enderror">
                                <option selected disabled>Select Product brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected( old('brand_id') == $brand->id )>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @can('product status')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-status">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="basic-default-status" class="form-control  @error('status') border-danger @enderror">
                                    <option selected disabled>Select Product Status</option>
                                        <option value="active" @selected( old('status') == 'active' )>active</option>
                                        <option value="pending" @selected( old('status') == 'pending' )>pending</option>
                                </select>
                            </div>
                        </div>
                    @endcan

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('image') border-danger @enderror" name="image">
                        </div>
                      </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-brand">Product Colors & sizes</label>
                        <div class="col-sm-10">
                            <div class="col-md">

                                <div class="d-flex justify-content-between">

                                    <div class="col-6">
                                        <small class="text-light fw-semibold d-block">Select Colors</small>

                                        @foreach ($colors as $color)

                                        <div class="form-check mt-3 d-inline-block mx-1">
                                            <input class="form-check-input  @error('color') border-danger @enderror" type="checkbox" value="{{$color->id}}" name='color[]'
                                                id="defaultCheck{{$color->id}}"

                                                @foreach (old('color') ?? []  as $productColor)
                                                @if (($productColor) == $color->id)
                                                    {{ 'checked' }}
                                                @endif
                                                @endforeach
                                                >
                                            <label class="form-check-label" for="defaultCheck{{$color->id}}"> {{$color->name}} </label>
                                        </div>

                                        @endforeach


                                    </div>


                                    <div class="col-6">
                                        <small class="text-light fw-semibold d-block">select sizes</small>

                                        @foreach ($sizes as $size)

                                        <div class="form-check mt-3 d-inline-block mx-1">
                                            <input class="form-check-input  @error('size') border-danger @enderror" type="checkbox" value="{{$size->id}}" name='size[]'
                                                id="defaultCheck{{$size->id}}"
                                                @foreach (old('size') ?? [] as $id)
                                                    @if ($id == $size->id)
                                                        {{'checked'}}
                                                    @endif
                                                @endforeach
                                                >
                                            <label class="form-check-label" for="defaultCheck{{$size->id}}"> {{$size->name}} </label>
                                        </div>

                                        @endforeach


                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ route('products.myProducts') }}" class="btn btn-secondary">back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
