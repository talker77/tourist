<?php

namespace App\Repository;

use App\Entity\AttractionImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AttractionImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttractionImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttractionImage[]    findAll()
 * @method AttractionImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttractionImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttractionImage::class);
    }

    // /**
    //  * @return AttractionImage[] Returns an array of AttractionImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttractionImage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
