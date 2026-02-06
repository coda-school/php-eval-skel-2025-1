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
        EntityManagerInterface $entityManager
    ): Response
    {
        $tweet = $tweetService->findTweetById($id);
        if (!$tweet) {
            throw $this->createNotFoundException('Tweet non trouvé');
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $likeRepository = $entityManager->getRepository(Like::class);
        $like = $likeRepository->findOneBy([
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
            $like->setUserId($user->getId());
            $like->setCreatedBy($user);
            $like->setCreatedDate(new \DateTime());
            $entityManager->persist($like);
        }
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
