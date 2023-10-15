<?php

use App\Models\Voucher;
use App\Models\WishListItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EndUser\Cart\CartController;
use App\Http\Controllers\EndUser\Home\HomeController;
use App\Http\Controllers\EndUser\Shop\ShopController;
use App\Http\Controllers\EndUser\Login\LoginController;
use App\Http\Controllers\EndUser\Order\OrderController;
use App\Http\Controllers\EndUser\Social\SocialController;
use App\Http\Controllers\EndUser\Vocher\VoucherController;
use App\Http\Controllers\EndUser\Address\AddressController;
use App\Http\Controllers\EndUser\Contact\ContactController;
use App\Http\Controllers\EndUser\Payment\PaymentController;
use App\Http\Controllers\EndUser\Product\ProdcutController;
use App\Http\Controllers\EndUser\Profile\ProfileController;
use App\Http\Controllers\PdfGenerate\PdfGenerateController;
use App\Http\Controllers\EndUser\CartItem\CartItemController;
use App\Http\Controllers\EndUser\Chat\ChatController;
use App\Http\Controllers\EndUser\ChatMessage\ChatMessageController;
use App\Http\Controllers\EndUser\CheckOut\CheckOutController;
use App\Http\Controllers\EndUser\Register\RegisterController;
use App\Http\Controllers\EndUser\Wishlist\WishListController;
use App\Http\Controllers\EndUser\ProductRate\ProductRateController;
use App\Http\Controllers\EndUser\Subscribe\SubscribeController;
use App\Http\Controllers\EndUser\WishListItems\WishListItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
here is where you can get access to all end user routes
|
*/


Route::group(['middleware' => ['prevent-back-history' , 'userActivity','throttle:80,1']],function(){


    Route::group([
        'prefix'=>'login',
        'as'=>'user-login.',
        'controller'=>LoginController::class
    ],function(){
        Route::get('/','create')->name('create');
        Route::post('/store','store')->name('store');
        Route::middleware('auth')->delete('/signout','destroy')->name('destroy');
    });

    Route::group([
        'prefix'=>'social-login',
        'as'=>'social-login.',
        'controller'=>SocialController::class
    ],function(){
        Route::get('/google','redirectToGoogle')->name('google');
        Route::get('/google/callback','handleCallback')->name('google.handle');
    });


    Route::group([
        'as'=>'home.',
        'controller'=>HomeController::class
    ],function () {
        Route::get('/','index')->name('show');
    });

    Route::group([
        'prefix'=>'contact',
        'as'=>'contact.',
        'controller'=>ContactController::class
    ],function () {
        Route::get('/','index')->name('show');
        Route::post('/store','store')->name('store');
    });

    Route::group([
        'prefix'=>'register',
        'as'=>'user-register.',
        'controller'=>RegisterController::class
    ],function () {
            Route::get('/','create')
                ->name('create');
            Route::post('store','store')->name('store');
    });

    Route::group([
        'prefix'=>'shop',
        'as'=>'shop.',
        'controller'=>ShopController::class
    ],function (){
        Route::get('/','index')->name('show');
        // Route::post('/filter','filterAndSearch')->name('filter');
        Route::get('/search','index')->name('search');
        Route::get('/category/{category}','categoryProduct')->name('category');
        Route::get('/brand/{brand}','brandProduct')->name('brand');
    });


    Route::group([
        'prefix'=>'prodcuts-details',
        'as'=>'products-details.',
        'controller'=>ProdcutController::class
    ],function (){
        Route::get('/{product}','index')->name('show');
        Route::post('/{product}','productRates')->name('rates');
    });


    Route::group([
        'prefix'=>'new-product-rate',
        'as'=>'new-product-rate.',
        'controller'=>ProductRateController::class
    ],function (){
        Route::post('/','store')->name('store');
        Route::post('/delete-rate','destroy')->name('destroy');
    });


    Route::group([
        'middleware'=>['auth']
    ],function (){

        Route::group([
            'prefix'=>'profile',
            'as'=>'end-user.profile.',
            'controller'=>ProfileController::class
        ],function (){
                Route::get('/edit','edit')->name('edit');
                Route::put('/update','update')->name('update');
                Route::patch('/update/image','updateImage')->name('image.update');
                Route::delete('/destroy','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'wish-lists',
            'as'=>'user-wishlists.',
            'controller'=>WishListController::class
        ],function (){
            Route::get('/','index')->name('all');
            Route::post('/store','store')->name('store');
            Route::get('/edit','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::post('/destroy','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'wish-list-items',
            'as'=>'wish-list-item.',
            'controller'=>WishListItemController::class
        ],function (){
            Route::post('/','index')->name('all');
            Route::post('/store/wishlist','store')->name('store');
            Route::post('/destroy','destroy')->name('destroy');
        });


        Route::group([
            'prefix'=>'cart',
            'as'=>'cart.',
            'controller'=>CartController::class
        ],function(){
            route::get('/','index')->name('show');
        });

        Route::group([
            'prefix'=>'cart-item',
            'as'=>'cart-item.',
            'controller'=>CartItemController::class
        ],function (){
            Route::post('/store','store')->name('store');
            Route::post('/update','update')->name('update');
            Route::post('/destroy','destroy')->name('destroy');
        });

        Route::group([
            'prefix'=>'checkout',
            'as'=>'checkout.',
            'controller'=>PaymentController::class
        ],function(){
            Route::middleware('checkout_item_check')->get('/{order}','index')->name('show');
            Route::post('/{order}/payment','payment')->name('payment');
            Route::get('/payment/success','success')->name('success');
            Route::get('/payment/cancel','cancel')->name('cancel');
        });

        Route::group([
            'prefix'=>'user-address',
            'as'=>'user-address.',
            'controller'=>AddressController::class
        ],function(){
            Route::post('/','store')->name('store');
            Route::post('/delete','destroy')->name('destroy');
            Route::post('/cities','getCountryCities')->name('cities');
        });

        Route::group([
            'prefix'=>'user-voucher',
            'as'=>'user-voucher.',
            'controller'=>VoucherController::class,
        ],function(){
            Route::middleware('voucherCheck')->post('/','apply')->name('apply');
            Route::post('/delete','destroy')->name('destroy');
        });


        Route::group([
            'prefix'=>'my-orders',
            'as'=>'my-orders.',
            'controller'=>OrderController::class
        ],function(){
            Route::get('/','index')->name('all');
            Route::get('/{order}/details','details')->name('show');
            Route::post('/search','search')->name('search');
        });


        Route::group([
            'prefix'=>'generate-pdf',
            'as'=>'generate-pdf.',
            'controller'=>PdfGenerateController::class
        ],function(){
            Route::get('/{order}','index')->name('create');
        });

        Route::group([
            'prefix'=>'customer-service',
            'as'=>'customer-service.',
            'controller'=>ChatController::class
        ],function(){
            Route::get('/','index')->name('show');

            Route::group([
                'prefix'=>'messages',
                'as'=>'messages.',
                'controller'=>ChatMessageController::class
            ],function(){
                Route::post('/store','store')->name('store');
            });

        });

    });


    Route::group([
        'prefix'=>'subscribe',
        'as'=>'subscribe.',
        'controller'=>SubscribeController::class
    ],function(){
        Route::post('/store','store')->name('store');
    });





});
