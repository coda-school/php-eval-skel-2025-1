<?php

namespace App\Controller\Profil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/profil', name: 'profil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('profil/index/index.html.twig', [
            'controller_name' => 'Profil/IndexController',
        ]);
    }
}
