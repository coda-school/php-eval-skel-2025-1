<?php

namespace App\Controller\Tweet;

use App\Entity\Like;
use App\Entity\Tweet;
use App\Entity\User;
use App\Service\LikeService;
use App\Service\TweetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class LikeController extends AbstractController
{
    #[Route('/tweet/{id}', name: 'tweet_like', methods:['GET', 'POST'])]
    public function index
    (
        int $id,
        TweetService $tweetService,
        LikeService $likeService,
        EntityManagerInterface $entityManager
    ): Response
    {
        $tweet = $tweetService->findById($id);

        $user = $this->getUser();

        $likeService->toggleLike($user, $tweet, $entityManager);
        $like = $this->likeRepository->findOneBy([
            'createdBy' => $user,
            'tweet_id' => $tweet->getId(),
            'isDeleted' => false
        ]);

        if ($like) {
            $like->setIsDeleted(true);
            $like->setDeletedBy($user);
            $like->setDeletedDate(new \DateTime());
        } else {
            $like = new Like();
            $like->setTweetId($tweet->getId());
            $like->setCreatedBy($user);
            $like->setCreatedDate(new \DateTime());
            $entityManager->persist($like);
        }
        $entityManager->flush();

        // Rediriger vers la page précédente ou l'accueil
        return $this->redirectToRoute('app_home_index');
    }
}
