<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     * @return JsonResponse
     */
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
           'login' => $user->getUsername(),
           'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/api/logout", name="api_logout")
     * @return JsonResponse
     */
    public function logout()
    {

    }

}