<?php

namespace App\Controller\Tweet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('/tweet/show', name: 'app_tweet_show')]
    public function index(): Response
    {
        return $this->render('tweet/show/index.html.twig', [
            'controller_name' => 'Tweet/ShowController',
        ]);
    }
}
