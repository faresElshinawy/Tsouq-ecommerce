<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\Observers\SettingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);
        Setting::observe(SettingObserver::class);
    }
}
