<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * Base controller for the JSON API. Provides thin helpers that delegate to the
 * shared response envelope, keeping concrete controllers focused on intent.
 */
abstract class ApiController extends Controller
{
    protected function ok(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return ApiResponse::success($data, $message, $status);
    }

    protected function created(mixed $data = null, string $message = 'Created'): JsonResponse
    {
        return ApiResponse::success($data, $message, 201);
    }

    protected function fail(string $message, int $status = 400): JsonResponse
    {
        return ApiResponse::error($message, $status);
    }
}
