<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class dashboardAuth extends Middleware
{

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login.create');
    }
}
