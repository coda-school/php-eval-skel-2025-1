<?php

namespace App\Repository;

use App\Entity\Follow;
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
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les derniers tweets des comptes suivis par un utilisateur
     */
    public function findFollowTimelineByUserId(int $userId, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder('t')
            ->select('t')
            ->innerJoin(Follow::class, 'f', 'WITH', 't.createdBy = f.following_id')
            ->where('f.follower_id = :userId')
            ->andWhere('t.isDeleted = false')
            ->andWhere('f.isDeleted = false')
            ->setParameter('userId', $userId)
            ->orderBy('t.createdDate', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
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
            ->getOneOrNullResult();
    }
}
