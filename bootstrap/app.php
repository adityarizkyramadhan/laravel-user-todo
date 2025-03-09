<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            // Log atau laporkan exception
            logger()->error($e->getMessage());
        });

        $exceptions->renderable(function (Throwable $e, $request) {
            $statusCode = method_exists($e, 'getCode') ? $e->getCode() : 500;
            $errorCode = $e->getCode() ?: $statusCode;

            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage(),
                'status_code' => $statusCode,
                'error_code' => $errorCode,
            ], $statusCode);
        });
    })
    ->create();
