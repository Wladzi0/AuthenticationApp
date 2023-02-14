<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\DTO\UserRequestDTO;
use App\Entity\User;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/api/auth")
 */
class AuthController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private AuthService $authService;

    public function __construct(EntityManagerInterface $entityManager, AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * @Route("/register", name="user_register")
     * @throws \JsonException
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder): JsonResponse
    {
        $request = $this->authService->transformJsonBody($request);

        $dto = new UserRequestDTO($request);

        $user = new User($dto);
        $user->setPassword($encoder->hashPassword($user, $dto->password));

        $this->entityManager->persist($user);
        $this->entityManager-> flush();

        return $this->authService->respondWithSuccess($user->getUserIdentifier());
    }

    /**
     * @Route("/api/login_check", name="login_check", methods={"POST"})
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        return new JsonResponse([
            'token' => $JWTTokenManager->create($user),
        ]);
    }
}
