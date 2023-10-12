<?php

namespace App\Http\Controllers\Dashboard\ProductImage;

use App\Models\Product;
use App\Traits\UploadFile;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImage\ProductImageStoreRequest;

class ProductImageController extends Controller
{

    use UploadFile;

    public function __construct()
    {
        $this->middleware('permission:product-image all', ['only' => ['index','search']]);
        $this->middleware('permission:product-image create', ['only' => ['create','store']]);
        $this->middleware('permission:product-image delete', ['only' => ['destroy']]);
    }

    public function index(Product $product){
        return view('dashboard.pages.products.product-images.index',[
            'productImages'=>ProductImage::where('product_id',$product->id)->paginate(15),
            'product'=>$product
        ]);
    }


    public function create(Product $product){
        return view('dashboard.pages.products.product-images.create',[
            'product'=>$product
        ]);
    }

    public function store(ProductImageStoreRequest $request,Product $product){
        ProductImage::create([
            'image'=>$this->newImage(Product::$path,$request),
            'product_id'=>$product->id
        ]);
        return redirect()->back()->with('success','product image Created Successfully');
    }


    public function destroy(ProductImage $productImage){
        $productImage->delete();
        return redirect()->back()->with('success','product image Deleted Successfully');
    }
}
