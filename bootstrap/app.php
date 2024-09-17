<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // $middleware->validateCsrfTokens(except: [
        //     "http://localhost:8000/*"
        // ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\Localization::class);

        $middleware->alias([
            'auth' =>  \App\Http\Middleware\Authenticate::class,
            'clearNotification' =>  \App\Http\Middleware\ClearNotificationSession::class,
        ]);
        $middleware->append([
            // \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\Localization::class,

        ]);
        $middleware->validateCsrfTokens(
            except: []
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
