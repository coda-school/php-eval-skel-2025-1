<?php

namespace App\Service;

use App\Entity\Tweet;
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

    public function findTweetById(int $tweetId): Tweet
    {
        return $this->tweetRepository->findTweetById($tweetId);
    }

    public function findFollowTimelineByUserId(int $userId): array
    {
        return $this->tweetRepository->findFollowTimelineByUserId($userId);
    }

    public function findAll(): array
    {
        return $this->tweetRepository->findAllTweets();
    }

    public function findById(int $id): ?\App\Entity\Tweet
    {
        return $this->tweetRepository->find($id);
    }
}
