<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use anlutro\LaravelSettings\Facades\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'tax'=>10,
            'shop-description'=>'Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.',
            'store-address'=>'123 Street, New York, USA',
            'store-email'=>'info@example.com',
            'store-phone'=>'+012 345 67890',
            'home-button'=>'Home',
            'shop-button'=>'Shop',
            'control-panel-button'=>'Control Panel',
            'orders-button'=>'Orders',
            'contact-button'=>'Contact',
            'profile-button'=>'profile',
            'slider-type'=>'dynamic',
            'slider-one-image'=>'test',
            'slider-one-url'=>'http://127.0.0.1:8000/shop',
            'slider-one-title'=>'Fashionable Dress',
            'slider-one-sub-title'=>'10% OFF YOUR FIRST ORDER',
            'slider-two-image'=>'test',
            'slider-two-url'=>'http://127.0.0.1:8000/shop',
            'slider-two-title'=>'Fashionable Dress',
            'slider-two-sub-title'=>'10% OFF YOUR FIRST ORDER',
            'subscribe-title'=>'Stay Updated',
            'subscribe-description'=>'Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.',
            'new-letter-title'=>'newsletter',
            'our-shop-header'=>'our shop',
            'our-shop-title'=>'Shop',
            'orders-header'=>'orders',
            'orders-title'=>'Orders',
            'contact-header'=>'contact us',
            'contact-title'=>'Contact',
            'contact-sub-header'=>'Contact For Any Queries',
            'contact-description'=>'Justo sed diam ut sed amet duo amet lorem amet stet sea ipsum, sed duo amet et. Est elitr dolor elitr erat sit sit. Dolor diam et erat clita ipsum justo sed.',
            'profile-header'=>'PROFILE',
            'profile-title'=>"Profile",
            'wishlists-header'=>'WISH LISTS',
            'wishlists-title'=>'Wish Lists',
            'no-wishlists-holder'=>'you have no wish lists yet!',
            'no-wishlists-message'=>'Create a new wish list and save items for future purchases',
            'cart-header'=>'CART',
            'cart-title'=>'Cart',
            'checkout-header'=>'CHECKOUT',
            'checkout-title'=>'Checkout',
            'Billing-address-title'=>'Billing Address',
            'facebook'=>'https://www.facebook.com/fares.elshinawi',
            'instagram'=>'https://www.instagram.com/fares.elshinawy/',
            'twitter'=>'https://twitter.com/FElshinawy24671',
            'linked-in'=>'https://www.linkedin.com/in/fares-elshinawy-26830b258/',
        ];

        foreach($settings as $key => $value){
            Setting::set($key,$value);
            Setting::save();
        }    }
}
