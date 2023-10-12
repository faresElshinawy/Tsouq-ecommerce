<?php

namespace App\Http\Controllers\Dashboard\City;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\City\CityStoreRequest;
use App\Http\Requests\City\CityUpdateRequest;

class CityController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:city all', ['only' => ['index','search']]);
        $this->middleware('permission:city create', ['only' => ['create','store']]);
        $this->middleware('permission:city edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.cities.index',[
            'cities'=>City::with('country:id,name')->paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $cities = City::query()->with('country')->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.cities.city-search',[
                'cities'=>$cities
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.cities.create',[
            'countries'=>Country::get()
        ]);
    }

    public function store(CityStoreRequest $request){
        City::create([
            'name'=>$request->name,
            'country_id'=>$request->country_id
        ]);
        return redirect()->back()->with('success','city Created Successfully');
    }

    public function edit(City $city){
        return view('dashboard.pages.cities.edit',[
            'city'=>$city,
            'countries'=>Country::get()
        ]);
    }

    public function update(CityUpdateRequest $request,City $city){
        $city->update([
            'name'=>$request->name,
            'country_id'=>$request->country_id
        ]);
        return redirect()->back()->with('success','city Updated Successfully');
    }

    public function destroy(city $city){
        $city->delete();
        return redirect()->back()->with('success','city Deleted Successfully');
    }
}
