<?php

namespace App\Controller\Tweet;

use App\Service\CommentService;
use App\Service\LikeService;
use App\Service\TweetService;
use App\Service\UserService;
use App\Service\ViewService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('/tweet/{id}', name: 'app_tweet_show', methods: ['GET'])]
    public function index
    (
        LikeService    $likeService,
        ViewService    $viewService,
        CommentService $commentService,
        UserService    $userService,
        TweetService   $tweetService,
        EntityManagerInterface $entityManager,
                       $id,
    ): Response
    {
        $tweet = $tweetService->findTweetById($id);
        if (!$tweet) {
            throw $this->createNotFoundException('Tweet non trouvé');
        }

        // Appel du service pour enregistrer une nouvelle vue
        $viewService->addView($id, $this->getUser(), $entityManager);

        $author = $userService->findUserByTweetId($id);
        $nbLikes = $likeService->countLikesByTweetId($id);
        $nbViews = $viewService->countViewsByTweetId($id);
        $listComments = $commentService->findCommentsByTweetId($id);
        $nbComments = sizeof($listComments);

        return $this->render('tweet/show/index.html.twig', [
            'tweet' => $tweet,
            'author' => $author,
            'nbComments' => $nbComments,
            'likes' => $nbLikes,
            'views' => $nbViews,
            'listComments' => $listComments,
            'likeService' => $likeService,
        ]);
    }
}
