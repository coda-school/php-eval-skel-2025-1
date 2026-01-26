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
     * "Le user (auteur) d'un tweet"
     * Version fusionnée : Jointure explicite avec sécurité isDeleted
     */
    public function findAuthorByTweetId(int $tweetID): ?User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('App\Entity\Tweet', 't', 'WITH', 't.createdBy = u')
            ->where('t.id = :tweetID')
            ->andWhere('u.isDeleted = false')
            ->andWhere('t.isDeleted = false')
            ->setParameter('tweetID', $tweetID)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
