<?php

namespace App\Repository;

use App\Entity\LinksRealisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinksRealisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinksRealisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinksRealisation[]    findAll()
 * @method LinksRealisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinksRealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinksRealisation::class);
    }

    // /**
    //  * @return LinksRealisation[] Returns an array of LinksRealisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LinksRealisation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
