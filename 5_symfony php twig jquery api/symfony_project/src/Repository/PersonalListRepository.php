<?php

namespace App\Repository;

use App\Entity\PersonalList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PersonalList|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalList|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalList[]    findAll()
 * @method PersonalList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalList::class);
    }

    // /**
    //  * @return PersonalList[] Returns an array of PersonalList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonalList
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
