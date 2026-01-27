<?php

namespace App\Service;


use App\Repository\CommentRepository;
use App\Repository\FollowRepository;

readonly class FollowService
{
    public function __construct (
        private FollowRepository $followRepository,
    )
    {
    }

    public function countFollowersByUserId(int $userId): int
    {
        return $this->followRepository->countFollowersByUserId($userId);
    }

    public function countFollowingsByUserId(int $userId): int
    {
        return $this->followRepository->countFollowingsByUserId($userId);
    }
}
