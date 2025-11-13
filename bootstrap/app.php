<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware){
        $middleware->alias([
            'auth.user' => \App\Http\Middleware\AuthUserMiddleware::class,
            'is.admin' => \App\Http\Middleware\IsAdminMiddleware::class,
            'is.superadmin' => \App\Http\Middleware\IsSuperAdminMiddleware::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        ]);
        $middleware->trustProxies(
            '*',
            Request::HEADER_X_FORWARDED_ALL
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
