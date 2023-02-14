<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public function respondWithSuccess(string $userIdentifier, array $headers = []): JsonResponse
    {
        $data = [
            'status' => Response::HTTP_OK,
            'success' => sprintf('User %s successfully created', $userIdentifier),
        ];

        return new JsonResponse($data, Response::HTTP_OK, $headers);
    }

    /**
     * @throws \JsonException
     */
    public function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
