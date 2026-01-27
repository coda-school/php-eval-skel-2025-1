<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;


class TweetService
{
    public function __construct (
        private readonly TweetRepository $tweetRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function getTweetsOfUser(int $userId): array
    {
        return $this->tweetRepository->findTweetsByUserId($userId);
    }

    public function getUserOfTweet(int $tweetId): User
    {
        $tweet = $this->userRepository->findUserByTweetId($tweetId);
        return $tweet->getCreatedBy();
    }
}
