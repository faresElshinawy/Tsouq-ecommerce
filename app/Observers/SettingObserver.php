<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{

    public function updated(Setting $setting): void
    {
        Cache::clear();
    }

}
