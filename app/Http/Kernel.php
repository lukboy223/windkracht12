<?php

namespace App\Http;

use App\Http\Middleware\AdminAccess;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        // ...existing middleware...
        'admin' => AdminAccess::class,
    ];
}