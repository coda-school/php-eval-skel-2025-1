<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FollowController extends AbstractController
{
    #[Route('/profile/follow/{id}', name: 'app_profile_follow')]
    public function index(int $id): Response
    {
        // Logique de follow à implémenter ici si nécessaire
        return $this->redirectToRoute('app_home_index');
    }
}
