<?php

namespace App\Controller\Tweet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateController extends AbstractController
{
    #[Route('/tweet/create', name: 'app_tweet_create')]
    public function index(): Response
    {
        return $this->render('tweet/create/index.html.twig', [
            'controller_name' => 'Tweet/CreateController',
        ]);
    }
}
