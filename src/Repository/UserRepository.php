<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /* 9- Le user d'un tweet*/
    public function findAuthorByTweetId(int $tweetID): ?User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('App\Entity\Tweet', 't', 'WITH', 't.createdBy = u')
            ->where('t.id = :tweetID')
            ->andWhere('u.is_deleted = false')
            ->andWhere('t.is_deleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Récupère les derniers tweets des comptes suivis par un utilisateur
     */
    public function findLastFollowedTweets(int $userId): array
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
}
