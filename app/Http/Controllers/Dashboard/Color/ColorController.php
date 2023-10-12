<?php

namespace App\Http\Controllers\Dashboard\Color;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Color\ColorStoreRequest;
use App\Http\Requests\Color\ColorUpdateRequest;

class ColorController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:color all', ['only' => ['index','search']]);
        $this->middleware('permission:color create', ['only' => ['create','store']]);
        $this->middleware('permission:color edit', ['only' => ['edit','update']]);
        $this->middleware('permission:color delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.colors.index',[
            'colors'=>Color::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $colors = Color::query()->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.colors.color-search',[
                'colors'=>$colors
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.colors.create');
    }

    public function store(ColorStoreRequest $request){
        Color::create([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success','color Created Successfully');
    }

    public function edit(Color $color){
        return view('dashboard.pages.colors.edit',[
            'color'=>$color,
        ]);
    }

    public function update(ColorUpdateRequest $request,Color $color){
        $color->update([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success','color Updated Successfully');
    }

    public function destroy(Color $color){
        $color->delete();
        return redirect()->back()->with('success','color Deleted Successfully');
    }
}
