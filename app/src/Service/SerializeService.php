<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\DTO\UserRequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SerializeService
{
    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function getDeserializedUserFromRequest(Request $request): UserRequestDTO
    {
        $dto = $this->serializer->deserialize($request->getContent(), UserRequestDTO::class, 'json');

        $errors = $this->validator->validate($dto);
        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new BadRequestHttpException($errorsString);
        }

        return $dto;
    }
}
