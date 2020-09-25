<?php

namespace App\Repository;

use App\Entity\UserTicketBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserTicketBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTicketBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTicketBook[]    findAll()
 * @method UserTicketBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTicketBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTicketBook::class);
    }

    // /**
    //  * @return UserTicketBook[] Returns an array of UserTicketBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserTicketBook
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
