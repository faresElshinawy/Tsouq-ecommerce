<?php

namespace App\Http\Controllers\Dashboard\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryStoreRequest;
use App\Http\Requests\Country\CountryUpdateRequest;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:country all', ['only' => ['index','search']]);
        $this->middleware('permission:country create', ['only' => ['create','store']]);
        $this->middleware('permission:country edit', ['only' => ['edit','update']]);
        $this->middleware('permission:country delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.countries.index',[
            'countries'=>Country::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $countries = Country::query()->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.countries.country-search',[
                'countries'=>$countries
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.countries.create');
    }

    public function store(CountryStoreRequest $request){
        Country::create([
            'name'=>$request->name,
            'code'=>$request->code
        ]);
        return redirect()->back()->with('success','Country Created Successfully');
    }

    public function edit(Country $country){
        return view('dashboard.pages.countries.edit',[
            'country'=>$country,
        ]);
    }

    public function update(CountryUpdateRequest $request,Country $country){
        $country->update([
            'name'=>$request->name,
            'code'=>$request->code
        ]);
        return redirect()->back()->with('success','Country Updated Successfully');
    }

    public function destroy(Country $country){
        $country->delete();
        return redirect()->back()->with('success','Country Deleted Successfully');
    }
}
