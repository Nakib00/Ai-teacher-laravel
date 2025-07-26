<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ], $statusCode);
    }

    protected function validationErrorResponse($errors)
    {
        return response()->json([
            'success' => false,
            'status' => 422,
            'message' => 'Validation error',
            'data' => null,
            'errors' => $errors,
        ], 422);
    }

    protected function unauthorizedResponse(string $message = 'Unauthorized')
    {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => $message,
            'data' => null,
            'errors' => ['error' => $message],
        ], 401);
    }
}
