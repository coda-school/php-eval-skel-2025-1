<?php

namespace App\Repository;

use App\Entity\View;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<View>
 */
class ViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, View::class);
    }

    /**
     * Toutes les vues d’un tweet
     */
    public function countViewsByTweetId(int $tweetID): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.tweet = :tweetID')
            ->andWhere('v.is_deleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Toutes les vues de tous les tweets d'un user
     */
    public function countViewsOfTweetsByUserId(int $userID): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->innerJoin('v.tweet', 't')
            ->where('t.createdBy = :userID')
            ->andWhere('t.is_deleted = false')
            ->andWhere('v.is_deleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
