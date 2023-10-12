<?php

namespace App\Http\Controllers\EndUser\Address;

use App\Traits\Api;
use App\Models\City;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Address\AddressStoreRequest;

class AddressController extends Controller
{

    use Api;

    public function store(Request $request){
        $street = $request->get('street');
        $city_spare = $request->get('city_spare');
        $phone = $request->get('phone');
        $country_id = $request->get('country_id');
        $building_number = $request->get('building_number');
        $validator = Validator::make([
            'country_id'=>$country_id,
            'city_spare'=>$city_spare,
            'phone'=>$phone,
            'street'=>$street,
            'building_number'=>$building_number,
        ],[
            'country_id'=>'required|numeric|exists:countries,id',
            'city_spare'=>'required|min:3|max:255|unique:cities,name',
            'phone'=>'required|numeric|min:10',
            'street'=>'required|min:5|max:255',
            'building_number'=>'required|numeric',
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errors(),400);
        }

        $address = Address::create([
            'user_id'=>$request->user()->id,
            'street'=>$request->street,
            'phone'=>$request->phone,
            'country_id'=>$request->country_id,
            'city_spare'=>$request->city_spare,
            'building_number'=>$request->building_number
        ]);

        if($address){
            $address = Address::with('country:id,name')->where('id',$address->id)->first();
            return $this->apiResponse('success',$address);
        }
    }

    public function getCountryCities(Request $request){
        $country_id = $request->get('id');
        return view('endUser.pages.checkout.cities',[
            'cities'=>City::where('country_id',$country_id)->get()
        ])->render();
    }


    public function destroy(Request $request){
        $address_id = $request->get('address_id');
        $validator = Validator::make([
            'address_id'=>$address_id
        ],[
            'address_id'=>'required|gt:0|exists:addresses,id'
        ]);

        if($validator->fails()){
            return $this->apiResponse('validation failed',null,$validator->errorst(),400);
        }
        $address = Address::where('id',$address_id)->first();
        if($address->delete()){
            return $this->apiResponse('deleted');
        }
    }
}
