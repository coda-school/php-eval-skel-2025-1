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
     * "Le user d'un tweet"
     * Récupère un tweet et son auteur en une seule requête SQL (Jointure optimisée)
     */
    public function findUserByTweetId(int $tweetID): ?User
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

    /**
     * Récupère des suggestions d'utilisateurs à suivre
     */
    public function findSuggestions(int $currentUserId, int $limit = 3): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.id != :currentUserId')
            ->setParameter('currentUserId', $currentUserId)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
