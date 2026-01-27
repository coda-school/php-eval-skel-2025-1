<?php

namespace App\Service;


use App\Repository\CommentRepository;

readonly class CommentService
{
    public function __construct (
        private CommentRepository $commentRepository,
    )
    {
    }

    public function findCommentsByTweetId(int $tweetId): array
    {
        return $this->commentRepository->findCommentsByTweetId($tweetId);
    }

    public function findCommentsByUserId(int $userId): array
    {
        return $this->commentRepository->findCommentsByUserId($userId);
    }
}
