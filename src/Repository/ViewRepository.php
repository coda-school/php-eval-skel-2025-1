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
     * Compte toutes les vues d’un tweet
     */
    public function countByTweet(int $tweetID): int
    {
        return (int) $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.tweet = :tweetID')
            ->andWhere('v.isDeleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Compte toutes les vues de tous les tweets d'un utilisateur
     */
    public function countAllViewsOnUserTweets(int $userID): int
    {
        return (int) $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->innerJoin('v.tweet', 't')
            ->where('t.createdBy = :userID')
            ->andWhere('t.isDeleted = false')
            ->andWhere('v.isDeleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
