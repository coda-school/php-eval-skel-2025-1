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
     * "Tous les tweets d’un user + tri par date"
     */
    public function findByUser(int $userID): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.createdBy = :userID')
            ->andWhere('t.isDeleted = false')
            ->setParameter('userID', $userID)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère un tweet et son auteur
     */
    public function findTweetByUser(int $tweetID): ?Tweet
    {
        return $this->createQueryBuilder('t')
            ->select('u')
            ->innerJoin('t.createdBy', 'u')
            ->where('t.id = :tweetID')
            ->andWhere('t.isDeleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllTweets(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.isDeleted = false')
            ->orderBy('t.createdDate', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }
}
