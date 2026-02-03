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
}
