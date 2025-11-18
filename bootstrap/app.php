<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;





return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (Throwable $e, $request) {
            // dd($e);

            // JWT Exceptions (token missing, invalid, expired)
            if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status'  => 0,
                    'error'   => 'TokenExpired',
                    'message' => 'Your token has expired.',
                ], 401);
            }

            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'status'  => 0,
                    'error'   => 'TokenInvalid',
                    'message' => 'Your token is invalid.',
                ], 401);
            }

            if ($e instanceof JWTException) {
                // token not provided
                return response()->json([
                    'status'  => 0,
                    'error'   => 'Unauthenticated',
                    'message' => 'Please login to access this resource.',
                ], 401);
            }

            // Authentication fallback
            if ($e instanceof AuthenticationException || $e instanceof UnauthorizedHttpException) {
                return response()->json([
                    'status'  => 0,
                    'error'   => 'Unauthenticated',
                    'message' => 'Please login to access this resource.',
                ], 401);
            }

            // Route not found (only when genuinely missing)
            if ($e instanceof RouteNotFoundException) {
                return response()->json([
                    'status'  => 0,
                    'error'   => 'RouteNotFound',
                    'message' => 'Route not found.',
                ], 404);
            }

            // Default
            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            return response()->json([
                'status'  => 0,
                'error'   => class_basename($e),
                'message' => $e->getMessage(),
            ], $status);
        });
    })
    ->create();
