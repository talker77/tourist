<?php

namespace App\Repository;

use App\Entity\Navigation;
use App\Entity\NavigationItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NavigationItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavigationItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavigationItem[]    findAll()
 * @method NavigationItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavigationItem::class);
    }


    public function findByLocale(Navigation $navigation,$locale)
    {
        $qb =  $this->createQueryBuilder('n')
            ->andWhere('n.navigation = :navigation')
            ->setParameter('navigation', $navigation)
            ->orderBy('n.order','asc')
        ;
        $qb = $qb->getQuery();

        /*
        $qb->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
        $qb->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        */

        return $qb->getResult();

    }

    // /**
    //  * @return NavigationItem[] Returns an array of NavigationItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NavigationItem
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
