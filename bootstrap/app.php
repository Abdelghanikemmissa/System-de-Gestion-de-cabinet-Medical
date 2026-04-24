<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. Vos exceptions CSRF existantes
        $middleware->validateCsrfTokens(except: [
            '/secretaire/*',
            '/medecin/*',
            '/patient/*',
            '/rendezvous/*',
            '/consultation/*',
            '/ordonnance/*',
            '/login',
            '/logout',
        ]);

        // 2. AJOUT : Forcer le HTTPS en production
        $middleware->web(append: [
            \App\Http\Middleware\ForceHttps::class,
        ]);

        // 3. AJOUT : Faire confiance au proxy de Railway (Crucial)
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
    })->create();