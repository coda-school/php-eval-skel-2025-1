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

    public function create(\App\Entity\Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    public function delete(\App\Entity\Comment $comment): void
    {
        $this->commentRepository->remove($comment);
    }

    public function findById(int $id): ?\App\Entity\Comment
    {
        return $this->commentRepository->find($id);
    }
}
