<?php

namespace App\Repository;

use App\Entity\TicketBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketBook[]    findAll()
 * @method TicketBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketBook::class);
    }

    // /**
    //  * @return TicketBook[] Returns an array of TicketBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketBook
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
