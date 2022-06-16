<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }


    public function getTotalRating()
    {
        $sql = 'SELECT SUM(rating) as totalRating, COUNT(id) as totalReviews FROM p_review';
        return $this->getEntityManager()->getConnection()->executeQuery($sql)->fetch();
    }
    public function getTopReviews($start=0,$limit = 20){
        $qb = $this->createQueryBuilder('p_review')
            ->andWhere('p_review.rating >= 4')
            ->andWhere('p_review.deletedAt is null')
            ->andWhere('p_review.isActive=1')
            ->setFirstResult($start)
            ->setMaxResults($limit);
        $qb->orderBy('p_review.createdAt','DESC');
        $result = $qb->getQuery();
        return $result->getArrayResult();
    }
    public function getDatatableData(){
        $qb = $this->createQueryBuilder('p_review')
            ->select('p_review.id')
            ->addSelect('p_review.name')
            ->addSelect('p_review.title')
            ->addSelect('p_review.review')
            ->addSelect('p_review.from')
            ->addSelect('p_review.createdAt')
            ->addSelect('p_review.isActive')
        ;

        $qb->orderBy('p_review.createdAt','DESC');

        $result = $qb->getQuery();

        return $result->getResult();
    }
}
