<?php

namespace App\Controller\Tweet;

use App\Repository\TweetRepository;
use App\Service\CommentService;
use App\Service\LikeService;
use App\Service\ViewService;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[ORM\Column(type: 'string')]
    readonly private LikeService $likeService;
    readonly private ViewService $viewService;
    readonly private CommentService $commentService;

    #[Route('/tweet/show', name: 'app_tweet_show', methods: ['GET'])]
    public function index
    (
        $tweetId,
    ): Response
    {
        $nbLikes = $this->likeService->countLikesByTweetId($tweetId);
        $nbViews = $this->viewService->countViewsByTweetId($tweetId);
        $listComments = $this->commentService->findCommentsByTweetId($tweetId);

        return $this->render('tweet/show/index.html.twig', [
            'likes' => $nbLikes,
            'views' => $nbViews,
            'commentaires' => $listComments,
        ]);
    }
}
