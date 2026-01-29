<?php

namespace App\Controller\Home;

use App\Service\TweetService;
use App\Service\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(TweetService $tweetService, LikeService $likeService): Response
    {
        $tweets = $tweetService->findAll();

        return $this->render('home/index/index.html.twig', [
            'tweets' => $tweets,
            'likeService' => $likeService,
        ]);
    }
}
