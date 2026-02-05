<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('/profile/show/{id}', name: 'app_profile_show')]
    public function index(int $id, \App\Repository\UserRepository $userRepository, \App\Service\TweetService $tweetService, \App\Service\LikeService $likeService, \App\Service\CommentService $commentService): Response
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
