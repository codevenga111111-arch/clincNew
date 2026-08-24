<?php

use App\Http\Middleware\CheckSubscriptionLimit;
use App\Http\Middleware\EnsureClinicIsActive;
use App\Http\Middleware\RoleRedirect;
use App\Http\Middleware\ScopeToClinic;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'scope.clinic' => ScopeToClinic::class,
            'clinic.active' => EnsureClinicIsActive::class,
            'subscription.check' => CheckSubscriptionLimit::class,
            'role.redirect' => RoleRedirect::class,
        ]);

        $middleware->web(append: [
            ScopeToClinic::class,
            EnsureClinicIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
