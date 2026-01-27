<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Like>
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    /**
     * Tous les likes d’un tweet
     */
    public function countLikesByTweetId(int $tweetID): int
    {
        return (int)$this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->andWhere('l.tweet = :tweetID', 'l.is_deleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Tous les likes d'un user
     */
    public function countLikesByUserId(int $userID): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.createdBy = :userID')
            ->andWhere('l.is_deleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Tous les likes des tweets d'un user
     */
    public function countLikesOfTweetsByUserId(int $userID): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->innerJoin('l.tweet', 't')
            ->where('t.createdBy = :userID')
            ->andWhere('t.is_deleted = false')
            ->andWhere('l.is_deleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
