<?php

namespace App\Http\Controllers\Dashboard\Address;

use App\Models\City;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressUpdateRequest;

class AddressController extends Controller
{


    function __construct()
    {
    $this->middleware('permission:user address all', ['only' => ['index']]);
    $this->middleware('permission:user address edit', ['only' => ['edit','update','getCountryCities']]);
    $this->middleware('permission:user address delete', ['only' => ['destroy']]);
    }

    public function index(Request $request,User $user){

        $addresses = Address::query()->with('country:id,name,code')->where('user_id',$user->id);
        return view('dashboard.pages.users.address.index',[
            'addresses'=>$addresses->paginate(15),
            'user'=>$user->name
        ]);
    }

    public function edit(Address $address){
        return view('dashboard.pages.users..address.edit',[
            'address'=>$address,
            'countries'=>Country::get(),
            // 'cities'=>City::query()->where('country_id',$address->country_id)->get(),
            'user'=>$address->user_id
        ]);
    }


    public function getCountryCities(Request $request){

        if ($request->ajax()) {
            $country_id = trim($request->get('query'));
            $city_id = $request->get('city_id');
            return view('dashboard.pages.users.address.country-cities',[
                'cities'=>City::query()->where('country_id',$country_id)->get(),
                'city_id'=>$city_id
            ]);
        }

    }

    public function update(AddressUpdateRequest $request,Address $address){

        $address->update([
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'city_spare'=>$request->city_spare ?? null,
            'phone'=>$request->phone,
            'street'=>$request->street,
            'building_number'=>$request->building_number
        ]);
        return redirect()->back()->with('success','address Updated Successfully');
    }
}
