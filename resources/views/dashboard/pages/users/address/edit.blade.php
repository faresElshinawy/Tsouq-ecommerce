@extends('dashboard.layouts.master')


@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Address</h5>
            </div>
            <div class="card-body">

                <form action='{{ route('users.addresses.update', ['address' => $address->id]) }}' method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-street">Street</label>
                        <div class="col-sm-10">
                            <input type="text" value='{{ old('street') ?? $address->street }}'
                                class="form-control  @error('street') border-danger @enderror" id="basic-default-street"
                                name="street" placeholder="Street">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-defaul-phone">Phone</label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <span class="inline-block my-auto col-2">Country Code : <span
                                    class="text-primary">{{ $address->country->code }}</span></span>
                            <input type="number" value='{{ old('phone') ?? $address->phone }}'
                                class="form-control  @error('phone') border-danger @enderror" id="basic-default-phone"
                                name="phone" placeholder="Street">
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-defaul-building_number">building number</label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <input type="number" value='{{ old('building_number') ?? $address->building_number }}'
                                class="form-control  @error('building_number') border-danger @enderror" id="basic-default-building_number"
                                name="building_number" placeholder="Street">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-country">Country</label>
                        <div class="col-sm-10" id="city_data">
                            <select name="country_id" id="basic-default-country" class="form-control @error('country') border-danger @enderror">
                                <option selected disabled>select address country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @selected($country->id == old('country_id') || $country->id == $address->country_id)>{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    {{-- <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-city">Adderess Current City :
                            <span class="text-primary">{{ $address->city->name ?? $address->city_spare }}</span>
                        </label>
                        <div class="col-sm-10" id="country_cities">
                            <select name="city_id" id="basic-default-city" class="form-control @error('city') border-danger @enderror">
                                <option selected disabled>select different address city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected($city->id == old('city_id') || $city->id == $address->city_id)>{{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-city">Adderess Current City :
                            <span class="text-primary">{{ $address->city_spare }}</span>
                        </label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <input type="text" value='{{ old('city_spare') ?? $address->city_spare }}'
                                class="form-control  @error('city_spare') border-danger @enderror" id="basic-default-city_spare"
                                name="city_spare" placeholder="City Name">
                        </div>
                    </div>


                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ route('users.addresses.all', ['user' => $user]) }}"
                                class="btn btn-secondary">back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).on('change', '#basic-default-country', function(e) {
            e.preventDefault();
            var query = this.value;
            $.ajax({
                url: "{{ route('users.addresses.getCountryCities') }}",
                data: {
                    "query": query,
                    "_token": "{{ csrf_token() }}",
                    "city_id": " {{ $address->city_id }}"
                },
                datatype: 'html',
                type: 'POST',
                cache: false,
                success: function(data) {
                    $('#country_cities').empty().html(data);
                },
            });
        })
    </script>
@endsection
