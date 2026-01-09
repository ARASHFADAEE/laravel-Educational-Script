<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserMidalware as UserMidalware;
use App\Http\Middleware\AdminMiddleware as AdminMiddleware;
use App\Http\Middleware\LessonacsessMiddalware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
$middleware->alias([
            'user' => UserMidalware::class,
            'admin' => AdminMiddleware::class,
            'LessonAccsess'=>LessonacsessMiddalware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
