<?php

namespace App\Repository;

use App\Entity\Tweet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tweet>
 */
class TweetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tweet::class);
    }

    /**
     * Tous les tweets d’un user
     */
    public function findTweetsByUserId(int $userID): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.createdBy = :userID')
            ->andWhere('t.is_deleted = false')
            ->setParameter('userID', $userID)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
