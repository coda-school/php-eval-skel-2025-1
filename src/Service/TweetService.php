<?php

namespace App\Service;

use App\Repository\TweetRepository;


readonly class TweetService
{
    public function __construct (
        private TweetRepository $tweetRepository,
    )
    {
    }

    public function findTweetsByUserId(int $userId): array
    {
        return $this->tweetRepository->findTweetsByUserId($userId);
    }
}
