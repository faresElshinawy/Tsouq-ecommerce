<?php

namespace App\Http\Controllers\Dashboard\Size;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Size\SizeStoreRequest;
use App\Http\Requests\Size\SizeUpdateRequest;

class SizeController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:size all', ['only' => ['index','search']]);
        $this->middleware('permission:size create', ['only' => ['create','store']]);
        $this->middleware('permission:size edit', ['only' => ['edit','update']]);
        $this->middleware('permission:size delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.sizes.index',[
            'sizes'=>Size::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $sizes = Size::query()->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.sizes.size-search',[
                'sizes'=>$sizes
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.sizes.create');
    }

    public function store(SizeStoreRequest $request){
        Size::create([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success','size Created Successfully');
    }

    public function edit(Size $size){
        return view('dashboard.pages.sizes.edit',[
            'size'=>$size,
        ]);
    }

    public function update(SizeUpdateRequest $request,Size $size){
        $size->update([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success','size Updated Successfully');
    }

    public function destroy(Size $size){
        $size->delete();
        return redirect()->back()->with('success','size Deleted Successfully');
    }
}
