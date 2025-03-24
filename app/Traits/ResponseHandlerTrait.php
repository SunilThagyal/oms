<?php

namespace App\Traits;

trait ResponseHandlerTrait
{
    private function successResponse($data, string $message = 'Operation successful.'): array
    {
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];
    }

    private function errorResponse(\Exception $e, string $message = 'An error occurred.'): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'details' => $e->getMessage(),
        ];
    }
}
