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

    /**
     * Le user d'un tweet
     */
    public function findUserByTweetId(int $tweetID): ?User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('App\Entity\Tweet', 't', 'WITH', 't.createdBy = u.id')
            ->andWhere('t.id = :tweetID')
            ->andWhere('u.is_deleted = false')
            ->andWhere('t.is_deleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
