<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    public function getSuccessResponse(string $userIdentifier, array $headers = []): JsonResponse
    {
        $data = [
            'status' => Response::HTTP_OK,
            'success' => sprintf('User %s successfully created', $userIdentifier),
        ];

        return new JsonResponse($data, Response::HTTP_OK, $headers);
    }
}
