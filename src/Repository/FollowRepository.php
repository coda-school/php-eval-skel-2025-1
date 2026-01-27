<?php

namespace App\Repository;

use App\Entity\Follow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Follow>
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    /* Nombre d'abonnés*/
    public function countFollowersByUserId(int $userID): int
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->where('f.following = :userID')
            ->andWhere('f.is_deleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Nombre d'abonnements*/
    public function countFollowingsByUserId(int $userID): int
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->where('f.follower = :userID')
            ->andWhere('f.is_deleted = false')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
