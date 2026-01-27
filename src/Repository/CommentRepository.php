<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * "Tous les commentaires d’un tweet"
     */
    public function findCommentsByTweetId(int $tweetID): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.tweet = :tweetID')
            ->andWhere('c.is_deleted = false')
            ->setParameter('tweetID', $tweetID)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * "Tous les commentaires d'un user"
     */
    public function findCommentsByUserId(int $userID): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.createdBy = :userID')
            ->andWhere('c.is_deleted = false')
            ->setParameter('userID', $userID)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
