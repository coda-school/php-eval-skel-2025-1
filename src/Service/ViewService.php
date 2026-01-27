<?php

namespace App\Service;


use App\Repository\ViewRepository;

class ViewService
{
    public function __construct (
        private readonly ViewRepository $viewRepository,
    )
    {
    }

    public function getViewsOfTweet(int $tweetId): int
    {
        return $this->viewRepository->countViewsByTweetId($tweetId);
    }
}
