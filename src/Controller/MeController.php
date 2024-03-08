<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route("/api/me", name: "get_current_user", methods: ["GET"])]
    public function getCurrentUser(UserInterface $user): JsonResponse
    {
        $userData = [
            'email' => $user->getEmail(),
            'username' => $user->getFrontUsername()
        ];

        return new JsonResponse($userData);
    }

    #[Route("/api/me/update", name: "update_current_user", methods: ["PATCH"])]
    public function updateCurrentUser(UserInterface $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);
        $user->setEmail($requestContent['email']);
        $user->setFrontUsername($requestContent['username']);

        $this->userRepository->save($user);

        $data = [
            'email' => $user->getEmail(),
            'username' => $user->getFrontUsername(),
        ];

        return new JsonResponse($data);
    }
}
