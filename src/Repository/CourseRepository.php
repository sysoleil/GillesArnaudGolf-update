<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    // /**
    //  * @return Course[] Returns an array of Course objects
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
    /**
    * @return Course[] Returns an array of Course objects
    */

    // je veux créer une requête spécifique. Pour cela
    // je créé une méthode que je nomme.

    public function FindByWords ($word)

    {
        // je viens définir la variable en statique

        // la méthode createQueryBuilder est issue de ServiceEntityRepository qui étend elle même une autre classe
        // qui contient la méthode "createQueryBuilder"

        //Je vais récupérer la méthode "createQueryBuilder" (constructeur de SQL) pour créer ma requête et
        // j'affecte un alias à ma table course ("c")
        // et je le mets ensuite dans une variable $queryBuilder
        $queryBuilder  = $this->createQueryBuilder('c');

        // je sélectionne tout ce qu'il y a dans ma table avec la méthode select()
        $query = $queryBuilder->select('c')

            //Je dois sécuriser le contenu de la demande utilisateur avant de faire la requête, pour éviter
            // notammement les injections SQL. Pour ça j'utilise un placeholder :word
            // "On ne fait jamais confiance à l'utilisateur"
            // je cherche dans la colonne name de la table 'c'.
            ->where('c.name like :word')

            // Pour sécuriser mon code j'utilise setParameter pour remplacer le placeholder par la vraie valeur
            ->setParameter('word','%'.$word.'%')

            // Je demande un tri ascendant sur l'id
            ->orderBy('c.id', 'ASC')

            // Je récupére la requête finale
            ->getQuery();

        // J'exécute ma requête et je la stocke dans une variable
        $courses = $query->getResult();
        //dump($courses); die;
        // Je retourne la variable
        return $courses;
    }


   // */

    /*
    public function findOneBySomeField($value): ?Course
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
