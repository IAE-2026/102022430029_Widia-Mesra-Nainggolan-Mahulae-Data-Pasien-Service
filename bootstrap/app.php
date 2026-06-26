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
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'auth.apikey' => \App\Http\Middleware\ApiKeyMiddleware::class,
        'auth.sso' => \App\Http\Middleware\VerifySSOToken::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found',
                    'errors' => null
                ], 404);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            }
        });

        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                    return null; 
                }
                
                \Illuminate\Support\Facades\Log::error("API 500 Error: " . $e->getMessage(), [
                    'exception' => $e
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Internal Server Error: ' . $e->getMessage(),
                    'errors' => null
                ], 500);
            }
        });
    })->create();
