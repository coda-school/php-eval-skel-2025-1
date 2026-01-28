<?php

namespace App\Controller\Tweet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LikeController extends AbstractController
{
    #[Route('/tweet/like', name: 'app_tweet_like')]
    public function index(): Response
    {
        return $this->render('tweet/like/index.html.twig', [
            'controller_name' => 'Tweet/LikeController',
        ]);
    }
}
