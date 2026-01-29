<?php

namespace App\DTO;

readonly class UserStatsDTO
{
    public function __construct(
        public int $id,
        public string $username,
        public int $followerCount,
        public int $followingCount,
        public int $tweetCount
    ) {}
}

