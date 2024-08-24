<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\MiddlewareServiceProvider;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware if needed
        // $middleware->append(AdminMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Register exception handling if needed
    })
    ->withProviders([
        AppServiceProvider::class,
        AuthServiceProvider::class,
        MiddlewareServiceProvider::class,
        // Add other providers as needed
    ])
    ->create();
    $app->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    });