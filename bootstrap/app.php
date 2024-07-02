<?php

use App\Common\ResponseBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if (request()->is('api/*')) {

            /** @var $responseBuilder ResponseBuilder */
            $responseBuilder = app()->make(ResponseBuilder::class);

            $exceptions->render(function (ValidationException $exception) use($responseBuilder) {
                return response()->json(
                    $responseBuilder->failed()
                        ->errors($exception->validator->errors()->toArray())
                        ->get(), 400);
            });

            $exceptions->render(function (NotFoundHttpException $exception) use($responseBuilder) {
                $response = $responseBuilder->errorAsString('Page not found')->get();
                return response()->json($response, 404);
            });

            $exceptions->render(function (MethodNotAllowedHttpException $exception) use($responseBuilder) {
                $response = $responseBuilder->errorAsString('Method not allowed')->get();
                return response()->json($response, 404);
            });
        }
    })->create();
