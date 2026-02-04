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
            ->where('c.tweet_id = :tweetID')
            ->andWhere('c.isDeleted = false')
            ->setParameter('tweetID', $tweetID)
            ->orderBy('c.createdDate', 'DESC')
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
            ->andWhere('c.isDeleted = false')
            ->setParameter('userID', $userID)
            ->orderBy('c.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function save(Comment $comment): void
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
    }

    public function remove(Comment $comment): void
    {
        $comment->setIsDeleted(true);
        $comment->setDeletedDate(new \DateTime());
        $this->getEntityManager()->flush();
    }
}
