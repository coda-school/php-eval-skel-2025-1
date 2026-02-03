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
     * "Tous les tweets d’un user"
     * Version fusionnée : sécurité + tri par date
     */
    public function findTweetsByUserId(int $userID): array
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
     * Récupère les derniers tweets des comptes suivis par un utilisateur
     */
    public function findFollowTimelineByUserId(int $userId): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->from('App\Entity\Tweet', 't')
            ->innerJoin('App\Entity\Follow', 'f', 'WITH', 't.createdBy = f.following')
            ->where('f.follower = :userId')
            ->andWhere('t.is_deleted = false')
            ->andWhere('f.is_deleted = false')
            ->setParameter('userId', $userId)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    public function findTweetById(int $tweetId): ?Tweet
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.id = :tweetId')
            ->setParameter('tweetId', $tweetId)
            ->getQuery()
            ->getResult();
    }
    public function findAllTweets(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.isDeleted = false')
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
