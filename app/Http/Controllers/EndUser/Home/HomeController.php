<?php

namespace App\Http\Controllers\EndUser\Home;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('endUser.pages.home.index',[
            'categories'=>Category::inrandomOrder()->with('products:id,category_id')->where('image','!=',null)->limit(6)->get(),
            'top_selling'=>Product::limit(8)->get(),
            'just_arrived'=>Product::orderBy('created_at','desc')->limit(8)->get(),
            'brands'=>Brand::inRandomOrder()->limit(2)->get()
        ]);
    }
}
