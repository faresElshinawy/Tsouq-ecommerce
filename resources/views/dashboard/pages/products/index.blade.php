@extends('dashboard.layouts.master')


@section('title', 'products')

@section('content')


    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">{{ isset($category) ? $category : (isset($brand) ? $brand : 'products') }}
                    /</span>products</h4>

            <div class="card mb-3">
                <div class="card-header">
                    <span class="text-dark">Filter By:</span>
                </div>
                <div class="card-body">

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="product_status">Status</label>
                        <div class="col-sm-10">
                            <select name="status" id="product_status"
                                class="form-control  @error('status') border-danger @enderror">
                                <option selected disabled>Select Product Status</option>
                                <option value=" ">all</option>
                                <option value="active" @selected(old('status') == 'active')>active</option>
                                <option value="pending" @selected(old('status') == 'pending')>pending</option>
                            </select>
                        </div>
                    </div>

                    <div class=" mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-data">spacific date</label>
                        <div class="d-flex">
                            <div class="col-6 m-1">
                                <label class="col-sm-2 col-form-label" for="basic-default-date">From :</label>
                                <input type="date" name="date-from" class="form-control" id="date_from">
                            </div>
                            <div class="col-6 m-1">
                                <label class="col-sm-2 col-form-label" for="basic-default-date" >To :</label>
                                <input type="date" name="date-to" class="form-control" id="date_to">
                            </div>
                        </div>


                    </div>

                    <div class="justify-content-start">
                        <button type="submit" class="btn btn-secondary" id="products-filter">Submit Filter</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="m-3 d-flex justify-content-between">
                    <div class="col-3">
                        <input type="text" class="form-control" id="product-search" placeholder="Search...">
                    </div>
                    @can('products create')
                        <a class="btn btn-primary text-white" href="{{ route('products.create') }}">Add New product</a>
                    @endcan
                </div>
                <div class="table text-nowrap">
                    <div id="search-result">
                        <div class="table-responsive  text-nowrap">
                            @if ($products->count() > 0)

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Count</th>
                                            <th>Discount</th>
                                            <th>user</th>
                                            <th>status</th>
                                            <th>Image</th>
                                            <th>Solded</th>
                                            <th>Refunds</th>
                                            <th>Updated by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                                    <strong>{{ $product->name }}</strong>
                                                </td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->count }}</td>
                                                <td>{{ $product->discount }}</td>
                                                <td>{{ $product->user->name }}</td>
                                                <td>{{ $product->status }}</td>
                                                <td>
                                                    @if (File::exists(public_path('uploads/products/' . $product->image)) || filter_var($product->image,FILTER_VALIDATE_URL))
                                                        <img style="width:200px;hight:200px"

                                                        @if (filter_var($product->image,FILTER_VALIDATE_URL))

                                                        src="{{ $product->image }}"

                                                        @else

                                                        src="{{ asset('uploads/products/' . $product->image) }}"

                                                        @endif

                                                        alt
                                                            class="rounded-square" />
                                                    @else
                                                        <div style="width:100px;hight:100px">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 61.8"
                                                                id="avatar">
                                                                <g data-name="Layer 2">
                                                                    <g data-name="—ÎÓÈ 1">
                                                                        <circle cx="30.9" cy="30.9" r="30.9"
                                                                            fill="#ffc200"></circle>
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
                                                </td>
                                                <td>{{ $product->solded_out }}</td>
                                                <td>{{ $product->refunds }}</td>
                                                <td>{{ $product->updated_by}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">

                                                            @can('products edit')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products.edit', ['product' => $product->id]) }}"><i
                                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                            @endcan


                                                            @can('product-image all')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products.product-image.all', ['product' => $product->id]) }}"><i
                                                                        class='bx bx-images'></i> Images</a>
                                                            @endcan

                                                            @can('products rate')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products.rates.all', ['product' => $product->id]) }}"><i
                                                                        class='bx bx-message-dots'></i> Rates</a>
                                                            @endcan

                                                            @can('products delete')
                                                                <form
                                                                    action="{{ route('products.destroy', ['product' => $product->id]) }}"
                                                                    method="Post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="dropdown-item"><i
                                                                            class="bx bx-trash me-1"></i>
                                                                        Delete</button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center text-primary my-3">You Have No Products Yet</p>
                            @endif
                        </div>
                        <div class="m-3">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>

$(document).ready(function() {
            $(document).on('click', '#products-filter', function(e) {
                e.preventDefault();
                var query = $('#product-search').val();
                var status = $('#product_status').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                $.ajax({
                    url: "{{ route('products.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'date_from':date_from,
                        'date_to':date_to,
                        'status':status
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });
        });

        $(document).ready(function() {
            $(document).on('keyup', '#product-search', function(e) {
                e.preventDefault();
                var query = this.value;
                var status = $('#product_status').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                $.ajax({
                    url: "{{ route('products.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}",
                        'date_from':date_from,
                        'date_to':date_to,
                        'status':status
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });
        });

        $(document).on('click', '#ajax-pagination a', function(e) {
            e.preventDefault();
            var query = $("#product-search").val();
            $.ajax({
                url: $(this).attr('href'),
                type: "post",
                datatype: 'html',
                data: {
                    "query": query,
                    '_token': "{{ csrf_token() }}"
                },
                cache: false,
                success: function(data) {
                    $('#search-result').html('');
                    $('#search-result').html(data);
                }
            });
        })
    </script>
@endsection
