<?php

namespace App\Service;

use App\Repository\LikeRepository;

readonly class LikeService
{
    public function __construct (
        private LikeRepository $likeRepository,
    )
    {
    }

    public function countLikesByTweetId(int $tweetId): int
    {
        return $this->likeRepository->countLikesByTweetId($tweetId);
    }

    public function countLikesByUserId(int $userId): int
    {
        return $this->likeRepository->countLikesByUserId($userId);
    }

    public function countLikesOfTweetsByUserId(int $userId): int
    {
        return $this->likeRepository->countLikesOfTweetsByUserId($userId);
    }

    public function toggleLike(\App\Entity\User $user, \App\Entity\Tweet $tweet, \Doctrine\ORM\EntityManagerInterface $entityManager): void
    {
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
            $like = new \App\Entity\Like();
            $like->setTweetId($tweet->getId());
            $like->setCreatedBy($user);
            $like->setCreatedDate(new \DateTime());
            $entityManager->persist($like);
        }
        $entityManager->flush();
    }
}
