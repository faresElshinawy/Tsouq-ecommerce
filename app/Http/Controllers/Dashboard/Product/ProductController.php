<?php

namespace App\Http\Controllers\Dashboard\Product;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\User;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Traits\UploadFile;
use App\Traits\ProductExtra;
use Illuminate\Http\Request;
use App\Events\ProductCreate;
use App\Events\ProductUpdate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\CreateProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{

    use ProductExtra;
    use UploadFile;


    public function __construct()
    {
        $this->middleware('permission:products all', ['only' => ['index','search']]);
        $this->middleware('permission:products myProducts', ['only' => ['myProducts','myProductSearch']]);
        $this->middleware('permission:products create', ['only' => ['create','store']]);
        $this->middleware('permission:products edit', ['only' => ['edit','update']]);
        $this->middleware('permission:products delete', ['only' => ['destroy']]);
    }


    public function index(){
        return view('dashboard.pages.products.index',[
            'products'=>Product::with('category','brand','user')->where('status','active')->paginate()
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $status = $request->get('status');
            $date_from = $request->get('date_from');
            $date_to = $request->get('date_to');
            $products = Product::query()->with('category','brand','user');
            if($query != null){
                $products->where('name','like',"%{$query}%");
            }
            if($status != null){
                $products->where('status',$status);
            }
            if($date_from != null && $date_to != null){
                $products->whereBetween('created_at',[$date_from,$date_to]);
            }
            return view('dashboard.pages.products.product-search',[
                'products'=>$products->paginate()
            ]);
        }
    }


    public function myProducts(){
        return view('dashboard.pages.products.my-product.index',[
            'products'=>Product::where('user_id',auth()->user()->id)->with('category:name,id','brand:name,id')->paginate()
        ]);
    }

    public function myProductSearch(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $products = Product::query()->where('user_id',$request->user()->id)->with('category','brand')->where('name','like',"%{$query}%")->paginate();
            return view('dashboard.pages.products.my-product.product-search',[
                'products'=>$products
            ]);
        }
    }



    public function create(){
        return view('dashboard.pages.products.create',[
            'categories'=>Category::get(),
            'brands'=>Brand::get(),
            'colors'=>Color::get(),
            'sizes'=>Size::get()
        ]);
    }

    public function store(ProductStoreRequest $request){
        DB::transaction(function() use ($request) {
            $product = Product::create([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'image'=>$this->newImage(Product::$path,$request),
                    'price'=>$request->price,
                    'count'=>$request->count,
                    'discount'=>$request->discount ?? 0,
                    'brand_id'=>$request->brand_id,
                    'status'=>$request->status ?? 'pending',
                    'category_id'=>$request->category_id,
                    'user_id'=>$request->user()->id
                ]);
                $this->updateProductAttributes($request->color,$product,'colors');
                $this->updateProductAttributes($request->size,$product,'sizes');
                event(new ProductCreate($product));
        });
        return redirect()->back()->with('success','product Created Successfully');
    }

    public function edit(Product $product){

        DB::table('notifications')->where('data->product_id',$product->id)->where('notifiable_id',Auth::user()->id)->where('data->notify_type','product')->update([
            'read_at'=>now()
        ]);


        return view('dashboard.pages.products.edit',[
            'product'=>$product,
            'categories'=>Category::get(),
            'brands'=>Brand::get(),
            'colors'=>Color::get(),
            'sizes'=>Size::get()
        ]);
    }

    public function update(ProductUpdateRequest $request,Product $product){
        DB::transaction(function () use ($request,$product) {
            $product->update([
                'name'=>$request->name,
                'description'=>$request->description,
                'image'=>$this->newImage(Product::$path,$request,$product->image),
                'price'=>$request->price,
                'count'=>$request->count,
                'discount'=>$request->discount ?? 0,
                'brand_id'=>$request->brand_id ?? '',
                'status'=>$request->status ?? 'pending',
                'category_id'=>$request->category_id,
                'updated_by'=>Auth::user()->name,
                'user_id'=>$request->user()->id
            ]);
            $this->updateProductAttributes($request->color,$product,'colors');
            $this->updateProductAttributes($request->size,$product,'sizes');
            event(new ProductUpdate($product));
        });

        return redirect()->back()->with('success','product Updated Successfully');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->back()->with('success','product Deleted Successfully');
    }
}
