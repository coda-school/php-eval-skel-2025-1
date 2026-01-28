<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('/profile/show', name: 'app_profile_show')]
    public function index(): Response
    {
        return $this->render('profile/show/index.html.twig', [
            'controller_name' => 'Profile/ShowController',
        ]);
    }
}
