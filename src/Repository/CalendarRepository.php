<?php

namespace App\Repository;

use App\Entity\Calendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendar[]    findAll()
 * @method Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendar::class);
    }
    public function getCalendarByLastName($lastName, $start)
    {
        // je récupère le query builder qui  permet de faire les requêtes SQL
        $queryBuilder = $this->createQueryBuilder('c');
        // 'c' = Nom que je donne

        // je construis en PHP ma requête façon SQL,
        // pour traduire ma requête en veritable requête SQL
        $query = $queryBuilder->select('c')
            ->join('c.user','u')
            ->Select('u')
            ->where('c.lastName = :lastName')
            ->orderBy('c.start', 'ASC')
            ->setParameter('lastName', '%' . $lastName . '%')
            ->getQuery();

        //Executer la requête en base de données pour recuperer les bonnes données
        $c = $query->getArrayResult();
        //Je  demande le resultat
        return $lastName;
    }


    // /**
    //  * @return Calendar[] Returns an array of Calendar objects
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
    public function findOneBySomeField($value): ?Calendar
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
