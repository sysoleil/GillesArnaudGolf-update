<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    // /**
    //  * @return Media[] Returns an array of Media objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Media
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
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
        // j'affecte un alias à ma table media ("m")
        // et je le mets ensuite dans une variable $queryBuilder
        $queryBuilder  = $this->createQueryBuilder('m');

        // je sélectionne tout ce qu'il y a dans ma table avec la méthode select()
        $query = $queryBuilder->select('m')

            //Je dois sécuriser le contenu de la demande utilisateur avant de faire la requête, pour éviter
            // notammement les injections SQL. Pour ça j'utilise un placeholder :word
            // "On ne fait jamais confiance à l'utilisateur"
            // je cherche dans la colonne name de la table 'm'.
            ->where('m.name like :word')

            // Pour sécuriser mon code j'utilise setParameter pour remplacer le placeholder par la vraie valeur
            ->setParameter('word','%'.$word.'%')

            // Je demande un tri ascendant sur l'id
            ->orderBy('m.id', 'ASC')

            // Je récupére la requête finale
            ->getQuery();

        // J'exécute ma requête et je la stocke dans une variable
        $medias = $query->getResult();
        //dump($medias); die;
        // Je retourne la variable
        return $medias;
    }


    // */

    /*
    public function findOneBySomeField($value): ?Course
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
