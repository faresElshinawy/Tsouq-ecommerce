@if ($cities->count() > 0)
<select name="city_id" id="basic-default-city" class="form-control">
    <option selected disabled>select different address city</option>
    @foreach ($cities as $city)
        <option value="{{ $city->id }}" @selected($city->id == old('city_id') || $city->id == $city_id)>{{ $city->name }}
        </option>
    @endforeach
</select>

@else
    <span class="text-primary my-auto">no cities for this country</span>
@endif


