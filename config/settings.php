<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Default Settings Store
	|--------------------------------------------------------------------------
	|
	| This option controls the default settings store that gets used while
	| using this settings library.
	|
	| Supported: "json", "database"
	|
	*/
	'store' => 'database',

	/*
	|--------------------------------------------------------------------------
	| JSON Store
	|--------------------------------------------------------------------------
	|
	| If the store is set to "json", settings are stored in the defined
	| file path in JSON format. Use full path to file.
	|
	*/
	'path' => storage_path().'/settings.json',

	/*
	|--------------------------------------------------------------------------
	| Database Store
	|--------------------------------------------------------------------------
	|
	| The settings are stored in the defined file path in JSON format.
	| Use full path to JSON file.
	|
	*/
	// If set to null, the default connection will be used.
	'connection' => null,
	// Name of the table used.
	'table' => 'settings',
	// If you want to use custom column names in database store you could
	// set them in this configuration
	'keyColumn' => 'key',
	'valueColumn' => 'value',

    /*
    |--------------------------------------------------------------------------
    | Cache settings
    |--------------------------------------------------------------------------
    |
    | If you want all setting calls to go through Laravel's cache system.
    |
    */
	'enableCache' => true,
	// Whether to reset the cache when changing a setting.
	'forgetCacheByWrite' => true,
	// TTL in seconds.
	'cacheTtl' => 15,

    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Define all default settings that will be used before any settings are set,
    | this avoids all settings being set to false to begin with and avoids
    | hardcoding the same defaults in all 'Settings::get()' calls
    |
    */
    'defaults' => [
        // 'shop-description'=>'Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.',
        // 'store-address'=>'123 Street, New York, USA',
        // 'store-email'=>'info@example.com',
        // 'store-phone'=>'+012 345 67890',
        // 'home-button'=>'Home',
        // 'shop-button'=>'Shop',
        // 'control-panel-button'=>'Control Panel',
        // 'orders-button'=>'Orders',
        // 'contact-button'=>'Contact',
        // 'profile-button'=>'profile',
        // 'slider-one-image'=>'test',
        // 'slider-one-url'=>'http://127.0.0.1:8000/shop',
        // 'slider-one-title'=>'Fashionable Dress',
        // 'slider-one-sub-title'=>'10% OFF YOUR FIRST ORDER',
        // 'slider-two-image'=>'test',
        // 'slider-two-url'=>'http://127.0.0.1:8000/shop',
        // 'slider-two-title'=>'Fashionable Dress',
        // 'slider-two-sub-title'=>'10% OFF YOUR FIRST ORDER',
        // 'subscribe-title'=>'Stay Updated',
        // 'subscribe-description'=>'Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.',
        // 'new-letter-title'=>'newsletter',
        // 'our-shop-header'=>'our shop',
        // 'our-shop-title'=>'Shop',
        // 'orders-header'=>'orders',
        // 'orders-title'=>'Orders',
        // 'contact-header'=>'contact us',
        // 'contact-title'=>'Contact',
        // 'contact-sub-header'=>'Contact For Any Queries',
        // 'contact-description'=>'Justo sed diam ut sed amet duo amet lorem amet stet sea ipsum, sed duo amet et. Est elitr dolor elitr erat sit sit. Dolor diam et erat clita ipsum justo sed.',
        // 'profile-header'=>'PROFILE',
        // 'profile-title'=>"Profile",
        // 'wishlists-header'=>'WISH LISTS',
        // 'wishlists-title'=>'Wish Lists',
        // 'no-wishlists-holder'=>'you have no wishlist yet!',
        // 'no-wishlists-message'=>'Create a new wish list and save items for future purchases',
        // 'cart-header'=>'CART',
        // 'cart-title'=>'Cart',
        // 'checkout-header'=>'CHECKOUT',
        // 'checkout-title'=>'Checkout',
        // 'Billing-address-title'=>'Billing Address',
        // 'facebook'=>'https://www.facebook.com/fares.elshinawi',
        // 'instagram'=>'https://www.instagram.com/fares.elshinawy/',
        // 'twitter'=>'https://twitter.com/FElshinawy24671',
        // 'linked-in'=>'https://www.linkedin.com/in/fares-elshinawy-26830b258/',
    ]
];
