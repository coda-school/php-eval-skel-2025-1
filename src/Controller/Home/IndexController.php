<?php

namespace App\Controller\Home;

use App\Service\TweetService;
use App\Service\LikeService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index
    (
        TweetService $tweetService,
        LikeService $likeService,
        UserService $userService,

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
        $maxPaginationPage = 1;
        if ($nbTwets > 0) {
            if ($nbTwets <= $limit) {
                $maxPaginationPage = 1;
            } elseif ($nbTwets <= 10 * $limit) {
                $maxPaginationPage = ceil($nbTwets / $limit);
            }
        }

        $suggestions = $userService->findSuggestions($user->getId());

        return $this->render('home/index/index.html.twig', [
            'tweets' => $tweets,
            'currentPage' => $page,
            'maxPaginationPage' => $maxPaginationPage,
            'likeService' => $likeService,
            'suggestions' => $suggestions,
        ]);
    }
}
