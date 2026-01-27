<?php

namespace App\Service;



use App\Entity\User;
use App\Repository\UserRepository;

readonly class UserService
{
    public function __construct (
        private UserRepository $userRepository,
    )
    {
    }

    public function findUserByTweetId(int $tweetId): User
    {
        return $this->userRepository->findUserByTweetId($tweetId);
    }
}
