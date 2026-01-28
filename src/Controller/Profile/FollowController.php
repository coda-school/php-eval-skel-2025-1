<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FollowController extends AbstractController
{
    #[Route('/profile/follow', name: 'app_profile_follow')]
    public function index(): Response
    {
        return $this->render('profile/follow/index.html.twig', [
            'controller_name' => 'Profile/FollowController',
        ]);
    }
}
