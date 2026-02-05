<?php

namespace App\Controller\Home;

use App\Service\TweetService;
use App\Service\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index
    (
        TweetService $tweetService,
        LikeService $likeService,

        #[MapQueryParameter]
        int $page = 1,

        #[MapQueryParameter]
        int $limit = 10,
    ): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $tweets = $tweetService->findFollowTimelineByUserId($user->getId(), $page, 10);
        $nbTwets = count($tweets);
        if ($tweets <= $limit) {
            $maxPaginationPage = 1;
        } elseif ($nbTwets <= 10 * $limit) {
            $maxPaginationPage = ceil($nbTwets / $limit);
        }

        return $this->render('home/index/index.html.twig', [
            'tweets' => $tweets,
            'maxPaginationPage' => $maxPaginationPage,
            'likeService' => $likeService,
        ]);
    }
}
