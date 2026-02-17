<?php

namespace App\Http\Controllers\EndUser\Shop;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Api;
use App\Traits\CacheHelper;
use App\Traits\FetchImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use ParagonIE\Sodium\Core\Curve25519\Ge\Cached;

class ShopController extends Controller
{
    use CacheHelper, Api,FetchImage;

    public function index(Request $request)
    {

        while(true = true){
            echo "wrong";
        }
        if ($request->ajax()) {
            return $this->filterAndSearch($request);
        }

        $products = $this->cacheQuery('products',60,null,[],'paginated');
        if ($request->get('query')) {
            $search = $request->get('query');
            $products = Product::search($search)->paginate();
        }
        $sizes = $this->cacheQuery('sizes', 60, 'products:id');
        $colors = $this->cacheQuery('colors', 60, 'products:id');
        $categories = $this->cacheQuery('categories', 60, 'products:id,category_id');
        $brands = $this->cacheQuery('brands', 60, 'products:id,brand_id');
        $productsCount = $this->cacheQuery('products',60,null,[],'count');

        return view('endUser.pages.shop.index', [
            'products' => $products,
            'sizes' => $sizes,
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
            'productsCount'=>$productsCount
        ]);
    }


    public function filterAndSearch(Request $request)
    {
        $brands = $request->get('brands');
        $categories = $request->get('categories');
        $colors = $request->get('colors');
        $sizes = $request->get('sizes');
        $prices = explode('-', $request->prices);
        $query = $request->get('query');
        $filter = $request->get('filter');
        $products = Product::query();
        if ($brands || $sizes || $colors || $categories || $prices) {
            if ($query && $query != false) {
                $products->where('name', 'like', "%{$query}%");
            }
            if ($categories && $categories[0] ?? false) {
                $products->whereIn('category_id', $categories);
            }
            if ($brands && $brands[0] ?? false) {
                $products->whereIn('brand_id', $brands);
            }
            if ($sizes && $sizes[0] ?? false) {
                $products->whereHas('sizes', function ($query) use ($sizes) {
                    $query->whereIn('size_id', $sizes);
                });
            }
            if ($colors && $colors[0] ?? false) {
                $products->whereHas('colors', function ($query) use ($colors) {
                    $query->whereIn('color_id', $colors);
                });
            }
            if ($filter && $filter != 'Best Rating') {
                $products->orderBy($filter, 'desc');
            }
            if ($filter == 'Best Rating') {
                $subquery = DB::table('products')
                    ->leftJoin('rates', 'rates.product_id', '=', 'products.id')
                    ->select('products.id', 'products.name as pro_name', DB::raw('avg(rates.rate) as avg_rate'))
                    ->groupBy('products.id', 'pro_name')
                    ->havingRaw('COUNT(rates.rate) >= 2');

                $products->joinSub($subquery, 'aggregated_products', function ($join) {
                    $join->on('products.id', '=', 'aggregated_products.id');
                })->orderBy('aggregated_products.avg_rate', 'desc')
                    ->select('products.*');
            }
            if ($prices && count($prices) > 1) {
                $products->whereBetween('price', [$prices[0], $prices[1]]);
            }
        }
        $products = $products->paginate();
        $data =  [
            'view' => view('endUser.pages.shop.products-filter', [
                'products' => $products,
            ])->render(),
            'nextPage'=>$products->nextPageUrl() == $products->lastPage() ? null : $products->nextPageUrl(),
        ];
        return $this->apiResponse('success',$data);
    }

    public function categoryProduct(Category $category)
    {
        $productsQuery = Product::query();
        $products = $productsQuery->where('category_id', $category->id)->paginate();
        $products->count = $productsQuery->count();
        $sizes = $this->cacheQuery('sizes', 60, 'products:id');
        $colors = $this->cacheQuery('colors', 60, 'products:id');
        $categories = $this->cacheQuery('categories', 60, 'products:id,category_id');
        $brands = $this->cacheQuery('brands', 60, 'products:id,brand_id');
        $productsCount = $this->cacheQuery('products',60,null,[],'count');

        return view('endUser.pages.shop.index', [
            'products' => $products,
            'sizes' => $sizes,
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
            'category_filter' => $category->id,
            'productsCount'=>$productsCount
        ]);
    }

    public function brandProduct(Brand $brand)
    {
        $productsQuery = Product::query();
        $products = $productsQuery->where('brand_id', $brand->id)->paginate();
        $products->count = $productsQuery->count();

        $sizes = $this->cacheQuery('sizes', 60, 'products:id');
        $colors = $this->cacheQuery('colors', 60, 'products:id');
        $categories = $this->cacheQuery('categories', 60, 'products:id,category_id');
        $brands = $this->cacheQuery('brands', 60, 'products:id,brand_id');
        $productsCount = $this->cacheQuery('products',60,null,[],'count');

        return view('endUser.pages.shop.index', [
            'products' => $products,
            'sizes' => $sizes,
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
            'brand_filter' => $brand->id,
            'productsCount'=>$productsCount
        ]);
    }
}
