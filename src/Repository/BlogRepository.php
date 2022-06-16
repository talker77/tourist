<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    public function findOneBySlug($value,$lang="en"): ?Blog
    {
        $qb =  $this->createQueryBuilder('b')
            ->leftJoin('b.posts','posts')
            ->andWhere('b.slug = :val')
            ->andWhere('b.lang = :lang')
            ->setParameter('val', $value)
            ->setParameter('lang', $lang)
            ->orderBy('posts.publishedAt', 'DESC')
            ->getQuery();


        return $qb->getOneOrNullResult();
    }

}
