<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\Chat\ChatController;
use App\Http\Controllers\Dashboard\City\CityController;
use App\Http\Controllers\Dashboard\Rate\RateController;
use App\Http\Controllers\Dashboard\Role\RoleController;
use App\Http\Controllers\Dashboard\Size\SizeController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Brand\BrandController;
use App\Http\Controllers\Dashboard\Color\ColorController;
use App\Http\Controllers\Dashboard\Order\OrderController;
use App\Http\Controllers\Dashboard\Search\SearchController;
use App\Http\Controllers\Dashboard\Address\AddressController;
use App\Http\Controllers\Dashboard\Country\CountryController;
use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Http\Controllers\Dashboard\Voucher\VoucherController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Feedback\FeedbackController;
use App\Http\Controllers\Dashboard\WishList\WishListController;
use App\Http\Controllers\Dashboard\WishList\WishListJController;
use App\Http\Controllers\Dashboard\OrderItem\OrderItemController;
use App\Http\Controllers\Dashboard\CreditCard\CreditCardController;
use App\Http\Controllers\Dashboard\Statistics\StatisticsController;
use App\Http\Controllers\Dashboard\Subscriber\SubscriberController;
use App\Http\Controllers\Dashboard\ChatMessage\ChatMessageController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Dashboard\ProductImage\ProductImageController;
use App\Http\Controllers\Dashboard\WishListItem\WishListItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['prevent-back-history' , 'userActivity']],function(){



    Route::prefix('dashboard')->middleware(['checkAccess'])->group(function(){

        Route::group([
            'prefix'=>'settings',
            'as'=>'settings.',
            'controller'=>SettingController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/search','search')->name('search');
            Route::get('/{setting}','edit')->name('edit');
            Route::put('/{setting}','update')->name('update');
        });


        Route::group([
                'prefix'=>'roles',
                'as'=>'roles.',
                'controller'=>RoleController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/search','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::put('/update/{id}','update')->name('update');
            Route::delete('/destroy/{id}','destroy')->name('destroy');
        });


        Route::group([
                'prefix'=>'multi-search',
                'as'=>'multi-search.',
                'controller'=>SearchController::class
        ],function(){
            Route::get('/mutli-search','index')->name('all');
        });


        Route::group([
            'as'=>'statistics.',
            'controller'=>StatisticsController::class
        ],function () {
            Route::get('/','index')->name('all');
        });

        Route::group([
            'prefix'=>'profile',
            'as'=>'profile.'
        ],function () {
                Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
                Route::patch('/update', [ProfileController::class, 'update'])->name('update');
                Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
        });

        Route::group([
            'prefix'=>'users',
            'as'=>'users.',
            'controller'=>UserController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/search','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{user}','edit')->name('edit');
            Route::put('/update/{user}','update')->name('update');
            Route::delete('/destroy/{user}','destroy')->name('destroy');

            Route::group([
                'prefix'=>'address',
                'as'=>'addresses.',
                'controller'=>AddressController::class
            ],function () {
                Route::get('/{user}','index')->name('all');
                Route::get('/edit/{address}','edit')->name('edit');
                Route::post('/country_cities','getCountryCities')->name('getCountryCities');
                Route::put('/update/{address}','update')->name('update');
            });


            Route::group([
                'prefix'=>'orders',
                'as'=>'orders.',
                'controller'=>OrderController::class
            ],function () {
                Route::get('/user-order/{user}','userOrder')->name('all');
                Route::post('/user-order-search','userOrderSearch')->name('order-search');
            });

        });

        Route::group([
            'prefix'=>'countries',
            'as'=>'countries.',
            'controller'=>CountryController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{country}','edit')->name('edit');
            Route::put('/update/{country}','update')->name('update');
            Route::delete('/destroy/{country}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'cities',
            'as'=>'cities.',
            'controller'=>CityController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{city}','edit')->name('edit');
            Route::put('/update/{city}','update')->name('update');
            Route::delete('/destroy/{city}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'categories',
            'as'=>'categories.',
            'controller'=>CategoryController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/products/{category}','categoryProduct')->name('products');
            Route::post('/products/search','categoryProductSearch')->name('products.search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{category}','edit')->name('edit');
            Route::put('/update/{category}','update')->name('update');
            Route::delete('/destroy/{category}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'brands',
            'as'=>'brands.',
            'controller'=>BrandController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/products/{brand}','brandProduct')->name('products');
            Route::post('/products/search','brandProductSearch')->name('products.search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{brand}','edit')->name('edit');
            Route::put('/update/{brand}','update')->name('update');
            Route::delete('/destroy/{brand}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'sizes',
            'as'=>'sizes.',
            'controller'=>SizeController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{size}','edit')->name('edit');
            Route::put('/update/{size}','update')->name('update');
            Route::delete('/destroy/{size}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'colors',
            'as'=>'colors.',
            'controller'=>ColorController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{color}','edit')->name('edit');
            Route::put('/update/{color}','update')->name('update');
            Route::delete('/destroy/{color}','destroy')->name('destroy');
        });        Route::group([
            'prefix'=>'colors',
            'as'=>'colors.',
            'controller'=>ColorController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{color}','edit')->name('edit');
            Route::put('/update/{color}','update')->name('update');
            Route::delete('/destroy/{color}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'products',
            'as'=>'products.',
            'controller'=>ProductController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/my-products','myProducts')->name('myProducts');
            Route::post('/my-products/search','myProductSearch')->name('myProductSearch');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{product}','edit')->name('edit');
            Route::put('/update/{product}','update')->name('update');
            Route::delete('/destroy/{product}','destroy')->name('destroy');


            Route::group([
                'prefix'=>'rates',
                'as'=>'rates.',
                'controller'=>RateController::class
            ],function(){
                Route::get('/{product}','index')->name('all');
                Route::post('/','search')->name('search');
                Route::delete('destroy/{rate}','destroy')->name('destroy');
            });


            Route::group([
                'prefix'=>'product-image',
                'as'=>'product-image.',
                'controller'=>ProductImageController::class
            ],function (){
                Route::get('/{product}','index')->name('all');
                Route::get('/{product}/create','create')->name('create');
                Route::post('/{product}/store','store')->name('store');
                Route::delete('/destroy/{productImage}','destroy')->name('destroy');
            });




        });

        Route::group([
            'prefix'=>'feedbacks',
            'as'=>'feedbacks.',
            'controller'=>FeedbackController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/search','search')->name('search');
            Route::delete('/destroy/{feedback}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'vouchers',
            'as'=>'vouchers.',
            'controller'=>VoucherController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{voucher}','edit')->name('edit');
            Route::put('/update/{voucher}','update')->name('update');
            Route::delete('/destroy/{voucher}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'wishlists',
            'as'=>'wishlists.',
            'controller'=>WishListController::class
        ],function () {
            Route::get('/{user}','index')->name('all');
            Route::post('/wishlist/search','search')->name('search');
            Route::delete('/destroy/{wishlist}','destroy')->name('destroy');


            Route::group([
                'prefix'=>'items',
                'as'=>'items.',
                'controller'=>WishListItemController::class
            ],function () {
                Route::get('/{wishlist}','index')->name('all');
            });

        });


        Route::group([
            'prefix'=>'credit-cards',
            'as'=>'credit-cards.',
            'controller'=>CreditCardController::class
        ],function () {
            Route::get('/{user}','index')->name('all');
            Route::post('/{user}','search')->name('search');
            Route::delete('/destroy/{creditcard}','destroy')->name('destroy');
        });


        Route::group([
            'prefix'=>'orders',
            'as'=>'orders.',
            'controller'=>OrderController::class
        ],function () {
            Route::get('/','index')->name('all');
            Route::post('/','search')->name('search');
            Route::get('/edit/{order}','edit')->name('edit');
            Route::put('/update/{order}','update')->name('update');
            Route::delete('/destroy/{order}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'notifications',
            'as'=>'notifications.',
            'controller'=>NotificationController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/mark-as-read','readAll')->name('read-all');
            Route::post('/delete-all','destroyAll')->name('delete-all');
            Route::delete('/{notification}/delete','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'subscribers',
            'as'=>'subscribers.',
            'controller'=>SubscriberController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::post('/search','search')->name('search');
            Route::delete('/{subscriber}','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'chats',
            'as'=>'chats.',
            'controller'=>ChatController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::get('/{chat}','show')->name('show');
            Route::post('/search','search')->name('search');



            Route::group([
                'prefix'=>'messages',
                'as'=>'messages.',
                'controller'=>ChatMessageController::class
            ],function(){
                Route::post('/store','store')->name('store');
                Route::post('/change-messages-status','changeMessagesStatus')->name('status-change');
            });
        });

    });

    require __DIR__.'/auth.php';

});

