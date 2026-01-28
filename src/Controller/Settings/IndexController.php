<?php

namespace App\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/settings/index', name: 'app_settings_index')]
    public function index(): Response
    {
        return $this->render('settings/index/index.html.twig', [
            'controller_name' => 'Settings/IndexController',
        ]);
    }
}
