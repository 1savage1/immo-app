<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    // ✅ ربط ملفات الـ routes (web + console) + health check
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // ✅ هنا نسجل الـ Middleware Aliases
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ ربط اسم مختصر "admin" بالميدلوير تاعنا
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);


        // ✅ ربط اسم مختصر "admin" بالميدلوير تاعنا
        // نستعمله لاحقاً هكذا في routes: ->middleware('admin')
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    // ✅ إعدادات الاستثناءات (نخليها كما هي)
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
