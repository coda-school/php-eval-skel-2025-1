<?php

namespace App\Controller\Profile;

use App\Repository\UserRepository;
use App\Service\CommentService;
use App\Service\LikeService;
use App\Service\TweetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('/profile/{id}', name: 'profile')]
    public function index
    (
        int $id,
        UserRepository $userRepository,
        TweetService $tweetService,
        LikeService $likeService,
        CommentService $commentService
    ): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $tweets = $tweetService->findTweetsByUserId($id);

        return $this->render('profile/show/index.html.twig', [
            'user' => $user,
            'tweets' => $tweets,
            'likeService' => $likeService,
            'commentService' => $commentService,
        ]);
    }
}
