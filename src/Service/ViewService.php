<?php

namespace App\Service;


use App\Repository\ViewRepository;

readonly class ViewService
{
    public function __construct (
        private ViewRepository $viewRepository,
    )
    {
    }

    public function countViewsByTweetId(int $tweetId): int
    {
        return $this->viewRepository->countViewsByTweetId($tweetId);
    }

    public function countViewsOfTweetsByUserId(int $userId): int
    {
        return $this->viewRepository->countViewsOfTweetsByUserId($userId);
    }
}
