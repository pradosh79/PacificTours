<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /** Uniform JSON envelope for every API and AJAX response. */
    protected function ok(mixed $data = null, ?string $message = null, int $status = 200)
    {
        return response()->json(array_filter([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], fn ($v) => $v !== null), $status);
    }

    protected function fail(string $message, int $status = 422, mixed $errors = null)
    {
        return response()->json(array_filter([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], fn ($v) => $v !== null), $status);
    }
}
