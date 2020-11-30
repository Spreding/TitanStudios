<?php

namespace App\Repository;

use App\Entity\CompanyMembers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyMembers|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyMembers|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyMembers[]    findAll()
 * @method CompanyMembers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyMembersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyMembers::class);
    }

    // /**
    //  * @return CompanyMembers[] Returns an array of CompanyMembers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompanyMembers
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
