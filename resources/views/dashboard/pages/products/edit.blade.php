@extends('dashboard.layouts.master')


@section('content')
<div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit product</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-center mb-3">
            @if (File::exists(public_path('uploads/products/' . $product->image)) || filter_var($product->image,FILTER_VALIDATE_URL))
                <img

                @if (filter_var($product->image,FILTER_VALIDATE_URL))

                src="{{ $product->image }}"

                @else

                src="{{ asset('uploads/products/' . $product->image) }}"

                @endif


                class="w-px-200 my-3  h-auto rounded-circle img-fluid" alt="">
            @else
                <div style="width:200px;hight:200px">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 61.8" id="avatar">
                        <g data-name="Layer 2">
                            <g data-name="—ÎÓÈ 1">
                                <circle cx="30.9" cy="30.9" r="30.9" fill="#ffc200"></circle>
                                <path fill="#677079" fill-rule="evenodd"
                                    d="M52.587 52.908a30.895 30.895 0 0 1-43.667-.291 9.206 9.206 0 0 1 4.037-4.832 19.799 19.799 0 0 1 4.075-2.322c-2.198-7.553 3.777-11.266 6.063-12.335 0 3.487 3.265 1.173 7.317 1.217 3.336.037 9.933 3.395 9.933-1.035 3.67 1.086 7.67 8.08 4.917 12.377a17.604 17.604 0 0 1 3.181 2.002 10.192 10.192 0 0 1 4.144 5.22z">
                                </path>
                                <path fill="#f9dca4" fill-rule="evenodd"
                                    d="m24.032 38.68 14.92.09v3.437l-.007.053a2.784 2.784 0 0 1-.07.462l-.05.341-.03.071c-.966 5.074-5.193 7.035-7.803 8.401-2.75-1.498-6.638-4.197-6.947-8.972l-.013-.059v-.2a8.897 8.897 0 0 1-.004-.207c0 .036.003.07.004.106z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M38.953 38.617v4.005a7.167 7.167 0 0 1-.095 1.108 6.01 6.01 0 0 1-.38 1.321c-5.184 3.915-13.444.704-14.763-5.983z"
                                    opacity=".11"></path>
                                <path fill="#f9dca4" fill-rule="evenodd"
                                    d="M18.104 25.235c-4.94 1.27-.74 7.29 2.367 7.264a19.805 19.805 0 0 1-2.367-7.264zM43.837 25.235c4.94 1.27.74 7.29-2.368 7.263a19.8 19.8 0 0 0 2.368-7.263z">
                                </path>
                                <path fill="#ffe8be" fill-rule="evenodd"
                                    d="M30.733 11.361c20.523 0 12.525 32.446 0 32.446-11.83 0-20.523-32.446 0-32.446z">
                                </path>
                                <path fill="#8a5c42" fill-rule="evenodd"
                                    d="M21.047 22.105a1.738 1.738 0 0 1-.414 2.676c-1.45 1.193-1.503 5.353-1.503 5.353-.56-.556-.547-3.534-1.761-5.255s-2.032-13.763 4.757-18.142a4.266 4.266 0 0 0-.933 3.6s4.716-6.763 12.54-6.568a5.029 5.029 0 0 0-2.487 3.26s6.84-2.822 12.54.535a13.576 13.576 0 0 0-4.145 1.947c2.768.076 5.443.59 7.46 2.384a3.412 3.412 0 0 0-2.176 4.38c.856 3.503.936 6.762.107 8.514-.829 1.752-1.22.621-1.739 4.295a1.609 1.609 0 0 1-.77 1.214c-.02.266.382-3.756-.655-4.827-1.036-1.07-.385-2.385.029-3.163 2.89-5.427-5.765-7.886-10.496-7.88-4.103.005-14 1.87-10.354 7.677z">
                                </path>
                                <path fill="#434955" fill-rule="evenodd"
                                    d="M19.79 49.162c.03.038 10.418 13.483 22.63-.2-1.475 4.052-7.837 7.27-11.476 7.26-6.95-.02-10.796-5.6-11.154-7.06z">
                                </path>
                                <path fill="#e6e6e6" fill-rule="evenodd"
                                    d="M36.336 61.323c-.41.072-.822.135-1.237.192v-8.937a.576.576 0 0 1 .618-.516.576.576 0 0 1 .619.516v8.745zm-9.82.166q-.622-.089-1.237-.2v-8.711a.576.576 0 0 1 .618-.516.576.576 0 0 1 .62.516z">
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
            @endif
        </div>
        <form action='{{route('products.update',['product'=>$product->id])}}' method="POST" enctype='multipart/form-data'>
            @csrf
            @method('put')

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                <div class="col-sm-10">
                    <input type="text" value='{{ old('name') ?? $product->name }}'
                        class="form-control  @error('name') border-danger @enderror" id="basic-default-name"
                        name="name" placeholder="Name">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-Description">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control  @error('name') border-danger @enderror" id="basic-default-Description"name="description"
                        placeholder="Description">{{ old('description') ?? $product->description }}</textarea>
                </div>
            </div>


            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-price">Price</label>
                <div class="col-sm-10">
                    <input type="number" value='{{ old('price') ?? $product->price }}'
                        class="form-control  @error('price') border-danger @enderror" id="basic-default-price"
                        name="price" placeholder="Price">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-count">count</label>
                <div class="col-sm-10">
                    <input type="number" value='{{ old('count') ?? $product->count }}'
                        class="form-control  @error('count') border-danger @enderror" id="basic-default-count"
                        name="count" placeholder="Count">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-discount">discount</label>
                <div class="col-sm-10">
                    <input type="number" value='{{ old('discount') ?? $product->discount }}'
                        class="form-control  @error('discount') border-danger @enderror" id="basic-default-discount"
                        name="discount"
                        placeholder="Discount Value">
                        <span class="text-muted d-block">note that the values you enter in discount is a precentage values</span>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-categore">category</label>
                <div class="col-sm-10">
                    <select name="category_id" id="basic-default-categore" class="form-control  @error('category_id') border-danger @enderror">
                        <option selected disabled>Select Product Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected( old('category_id') == $category->id or $category->id == $product->category_id )>{{ $category->name }}</option>
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
                            <option value="{{ $brand->id }}" @selected( old('brand_id') == $brand->id or $brand->id == $product->brand_id  )>{{ $brand->name }}</option>
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
                            <option value="active" @selected( old('status') == 'active' || $product->status == 'active')>active</option>
                            <option value="pending" @selected( old('status') == 'pending' || $product->status == 'pending')>pending</option>
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
                                            @foreach (old('color') ?? $product->colors as $productColor)
                                                @if (($productColor->id ?? $productColor) == $color->id)
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
                                        @foreach (old('size') ?? $product->sizes as $productSize)
                                            @if (($productSize->id ?? $productSize) == $size->id)
                                                {{'checked'}}
                                            @endif
                                        @endforeach
                                        >
                                    <label class="form-check-label" for="defaultCheck{{$size->id}}" > {{$size->name}} </label>
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
