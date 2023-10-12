<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Models\Product;
use App\Models\Category;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{
    use UploadFile;


    public function __construct()
    {
        $this->middleware('permission:category all', ['only' => ['index','search']]);
        $this->middleware('permission:category create', ['only' => ['create','store']]);
        $this->middleware('permission:category edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('dashboard.pages.categories.index',[
            'categories'=>Category::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $categories = Category::query()->where('name','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.categories.category-search',[
                'categories'=>$categories
            ]);
        }
    }

    public function categoryProduct(Category $category){
        return view('dashboard.pages.products.index',[
            'products'=>Product::with('category','brand','user')->Where('category_id',$category->id)->paginate(15),
            'category'=>$category->name
        ]);
    }

    public function categoryProductSearch(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $products = Product::query()->with('category','brand','user')->where('name','like',"%{$query}%")->Where('category_id',$query)->paginate(15);
            return view('dashboard.pages.products.product-search',[
                'products'=>$products
            ]);
        }
    }

    public function create(){
        return view('dashboard.pages.categories.create');
    }

    public function store(CategoryStoreRequest $request){
        Category::create([
            'name'=>$request->name,
            'image'=>$this->newImage(Category::$path,$request)
        ]);
        return redirect()->back()->with('success','category Created Successfully');
    }

    public function edit(Category $category){
        return view('dashboard.pages.categories.edit',[
            'category'=>$category,
        ]);
    }

    public function update(CategoryUpdateRequest $request,Category $category){
        $category->update([
            'name'=>$request->name,
            'image'=>$this->newImage(Category::$path,$request,$category->image)
        ]);
        return redirect()->back()->with('success','category Updated Successfully');
    }

    public function destroy(Category $category){
        $category->delete();
        return redirect()->back()->with('success','category Deleted Successfully');
    }
}
