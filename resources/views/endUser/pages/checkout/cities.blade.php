@if ($cities->count() > 0)
    @foreach ($cities as $city)
    <option value="{{ $city->id }}" @selected($city->id == old('city_id'))>{{ $city->name }}
    </option>
    @endforeach
@else

    <option selected>No Cities Belongs To The Country</option>

@endif
