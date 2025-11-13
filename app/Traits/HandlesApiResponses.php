<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HandlesApiResponses
{
    /**
     * Return a successful response.
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Operation completed successfully.',
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return a successful response with pagination info.
     */
    protected function successResponseWithPagination(
        mixed $data,
        string $message = 'Data retrieved successfully.',
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
                'has_more' => $data->hasMorePages(),
            ],
        ], $statusCode);
    }

    /**
     * Return an error response.
     */
    protected function errorResponse(
        string $message = 'An error occurred.',
        mixed $errors = null,
        int $statusCode = 400
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a validation error response.
     */
    protected function validationErrorResponse(array $errors, string $message = 'Validation failed.'): JsonResponse
    {
        return $this->errorResponse($message, $errors, 422);
    }

    /**
     * Return a not found response.
     */
    protected function notFoundResponse(string $message = 'Resource not found.'): JsonResponse
    {
        return $this->errorResponse($message, null, 404);
    }

    /**
     * Return an unauthorized response.
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized.'): JsonResponse
    {
        return $this->errorResponse($message, null, 401);
    }

    /**
     * Return a forbidden response.
     */
    protected function forbiddenResponse(string $message = 'Forbidden.'): JsonResponse
    {
        return $this->errorResponse($message, null, 403);
    }

    /**
     * Return a server error response.
     */
    protected function serverErrorResponse(string $message = 'Internal server error.'): JsonResponse
    {
        return $this->errorResponse($message, null, 500);
    }

    /**
     * Return a created response.
     */
    protected function createdResponse(mixed $data, string $message = 'Resource created successfully.'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Return a no content response.
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
