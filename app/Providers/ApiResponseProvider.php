<?php

namespace App\Providers;

use App\Enums\HttpResponseCodes;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Illuminate\Routing\ResponseFactory::macro('success', function (
            string $message,
            array|object $resultData = null,
            HttpResponseCodes $status = HttpResponseCodes::HttpOK
        ) {
            $response = [
                'success' => true,
                'message' => $message,
            ];

            if (! is_null($resultData)) {
                $response['data'] = $resultData;
            }

            return Response::json($response, $status->value);
        });

        \Illuminate\Routing\ResponseFactory::macro('error', function (
            string $message,
            HttpResponseCodes $status = HttpResponseCodes::HttpNotFound,
            array $errors = [],
        ) {

            $response = [
                'success' => false,
                'message' => $message,
            ];

            if (! empty($errors)) {
                $response['data'] = $errors;
            }

            return Response::json($response, $status->value);
        });
    }
}
