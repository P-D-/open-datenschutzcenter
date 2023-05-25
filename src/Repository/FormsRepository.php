<?php

namespace App\Repository;

use App\Entity\Forms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Forms|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forms|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forms[]    findAll()
 * @method Forms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forms::class);
    }

    public function findActiveByTeam($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.team = :val')
            ->andWhere('a.activ = 1')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findPublicByTeam($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.team = :val')
            ->andWhere('a.activ = 1')
            ->andWhere('a.status != 4')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findActiveByTeamAndUser($team, $user)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.team = :team')
            ->andWhere('a.assignedUser = :user')
            ->andWhere('a.activ = 1')
            ->setParameter('team', $team)
            ->setParameter('user', $user)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
