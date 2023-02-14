<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\ResponseService;
use App\Service\SerializeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiAuthController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private ResponseService $responseService;

    private SerializeService $serializeService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ResponseService $responseService,
        SerializeService $serializeService
    ) {
        $this->entityManager = $entityManager;
        $this->responseService = $responseService;
        $this->serializeService = $serializeService;
    }

    /**
     * @Route("/register", name="user_register")
     * @throws \JsonException
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder): JsonResponse
    {
        $deserializedDto = $this->serializeService->getDeserializedUserFromRequest($request);

        $user = new User($deserializedDto);
        $user->setPassword($encoder->hashPassword($user, $deserializedDto->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->responseService->getSuccessResponse($user->getUserIdentifier());
    }

    /**
     * @Route("/home", name="api_home")
     */
    public function getWelcomeMessage(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new homepage!',
        ]);
    }
}
