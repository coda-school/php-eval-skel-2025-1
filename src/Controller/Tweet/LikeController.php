<?php

namespace App\Controller\Tweet;

use App\Service\LikeService;
use App\Service\TweetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class LikeController extends AbstractController
{
    #[Route('/tweet/like/{id}', name: 'app_tweet_like')]
    #[IsGranted('ROLE_USER')]
    public function index(int $id, TweetService $tweetService, LikeService $likeService, EntityManagerInterface $entityManager): Response
    {
        $tweet = $tweetService->findById($id);

        if (!$tweet) {
            throw $this->createNotFoundException('Tweet non trouvé');
        }

        $user = $this->getUser();
        $likeService->toggleLike($user, $tweet, $entityManager);

        // Rediriger vers la page précédente ou l'accueil
        return $this->redirectToRoute('app_home_index');
    }
}
