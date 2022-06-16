<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function findOneBySlug($value,$lang="en"): ?BlogPost
    {
        $qb =  $this->createQueryBuilder('p')
            ->leftJoin('p.blog','blog')
            ->andWhere('p.slug = :val')
            ->andWhere('blog.lang = :lang')
            ->setParameter('val', $value)
            ->setParameter('lang', $lang)
            ->getQuery();


        return $qb->getOneOrNullResult();
    }
    public function getLastestBlog($value,$lang="en"): ?BlogPost
    {

        $qb =  $this->createQueryBuilder('p')
            ->leftJoin('p.blog','blog')
            ->andWhere('p.slug = :val')
            ->andWhere('blog.lang = :lang')
            ->andWhere('blog.favoriteAt is not null')
            ->setParameter('val', $value)
            ->setParameter('lang', $lang)
            ->getQuery();


        return $qb->getOneOrNullResult();
    }
}
