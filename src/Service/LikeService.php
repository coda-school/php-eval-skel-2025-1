<?php

namespace App\Service;

use App\Repository\LikeRepository;

class LikeService
{
    public function __construct (
        private readonly LikeRepository $likeRepository,
    )
    {
    }

    public function getLikesOfTweet(int $tweetId): int
    {
        return $this->likeRepository->countLikesByTweetId($tweetId);
    }
}
