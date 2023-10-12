<?php

namespace App\Http\Controllers\Dashboard\Brand;

use App\Models\Brand;
use App\Models\Product;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandStoreRequest;
use App\Http\Requests\Brand\BrandUpdateRequest;

class BrandController extends Controller
{
    use UploadFile;


    public function __construct()
    {
        $this->middleware('permission:brands all', ['only' => ['index','search']]);
        $this->middleware('permission:brands create', ['only' => ['create','store']]);
        $this->middleware('permission:brands edit', ['only' => ['edit','update']]);
        $this->middleware('permission:brands delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.brands.index',[
            'brands'=>Brand::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $brands = Brand::query()->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.brands.brand-search',[
                'brands'=>$brands
            ]);
        }
    }

    public function brandProduct(Brand $brand){
        return view('dashboard.pages.products.index',[
            'products'=>Product::with('category','brand','user')->Where('brand_id',$brand->id)->paginate(15),
            'brand'=>$brand->name
        ]);
    }

    public function brandProductSearch(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $products = Product::query()->with('category','brand','user')->where('name','like',"%{$query}%")->Where('brand_id',$query)->paginate(15);
            return view('dashboard.pages.products.product-search',[
                'products'=>$products
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.brands.create');
    }

    public function store(BrandStoreRequest $request){
        Brand::create([
            'name'=>$request->name,
            'image'=>$this->newImage(Brand::$path,$request)
        ]);
        return redirect()->back()->with('success','brand Created Successfully');
    }

    public function edit(Brand $brand){
        return view('dashboard.pages.brands.edit',[
            'brand'=>$brand,
        ]);
    }

    public function update(BrandUpdateRequest $request,Brand $brand){
        $brand->update([
            'name'=>$request->name,
            'image'=>$this->newImage(Brand::$path,$request,$brand->image)

        ]);
        return redirect()->back()->with('success','brand Updated Successfully');
    }

    public function destroy(Brand $brand){
        $brand->delete();
        return redirect()->back()->with('success','brand Deleted Successfully');
    }
}
