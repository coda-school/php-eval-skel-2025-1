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
     * Compte tous les likes d’un tweet
     */
    public function countLikesByTweetId(int $tweetID): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.tweet = :tweetID')
            ->andWhere('l.isDeleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Compte tous les likes effectués par un utilisateur
     */
    public function countByUser(int $userID): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.createdBy = :userID')
            ->andWhere('l.isDeleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Compte tous les likes reçus sur les tweets d'un utilisateur
     */
    public function countLikesByUserId(int $userID): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->innerJoin('l.tweet', 't')
            ->where('t.createdBy = :userID')
            ->andWhere('t.isDeleted = false')
            ->andWhere('l.isDeleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }


}
