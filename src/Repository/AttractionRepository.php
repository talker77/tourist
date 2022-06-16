<?php

namespace App\Repository;

use App\Entity\Attraction;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Attraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attraction[]    findAll()
 * @method Attraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attraction::class);
    }

    public function getActives()
    {
        return $this->findBy(array('deletedAt'=>null,'blog'=>null));
    }


    public function search($keyword)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.dontShowOnScreen is null')
            ->andWhere('attraction.deletedAt is null');


        $stateAndX = $qb->expr()->orX();

        $stateAndX->add('LOWER(attraction.title) like LOWER(:query)');
        $stateAndX->add('UPPER(attraction.title) like UPPER(:query)');
        $qb->setParameter('query', "%".$keyword."%");
        $qb->andWhere($stateAndX);


        $qb->orderBy('attraction.showOnHome','ASC');

        $result = $qb->getQuery();

        return $result->getResult();
    }

    public function getHomeAttraction($ids = array(), $limit = 3)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.dontShowOnScreen is null')
            ->andWhere('attraction.showOnHome is not null')
            ->andWhere('attraction.deletedAt is null')
            ->setMaxResults($limit);

        $qb->orderBy('attraction.showOnHome','ASC');

        $result = $qb->getQuery();

        return $result->getResult();
    }

    public function getApiRecommandation(Attraction  $attraction, $limit = 5)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.dontShowOnScreen is null')
            ->andWhere('attraction.id != :current')
            ->andWhere('attraction.deletedAt is null')
            ->setParameter('current',$attraction->getId())
            ->setMaxResults($limit);

        $qb->orderBy('attraction.showOnHome','ASC');

        $result = $qb->getQuery();

        return $result->getResult();
    }


    /**
     * @param null $limit
     * @return Attraction[]
     */
    public function getBlogItems($limit = null)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.blog is not null')
            ->andWhere('attraction.deletedAt is null');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        $qb->orderBy('attraction.createdAt','DESC');

        $result = $qb->getQuery();

        return $result->getResult();
    }
    /**
     * @param null $limit
     * @return Attraction[]
     */
    public function getMediaItems($limit = null)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.category=6')
            ->andWhere('attraction.deletedAt is null');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        $qb->orderBy('attraction.createdAt','DESC');

        $result = $qb->getQuery();

        return $result->getResult();
    }
    public function getAttractionsWithCategory()
    {
        $museums = $this->attractionByCategory(1);
        $experiences = $this->attractionByCategory(2);
        $services = $this->attractionByCategory(3);

        return [
            'museums' => $museums->getResult(),
            'experiences' => $experiences->getResult(),
            'services' => $services->getResult()
        ];
    }

    public function attractionByCategory($category = null)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.dontShowOnScreen is null')
            ->andWhere('attraction.deletedAt is null');

        if (!is_null($category)) {

            $qb->andWhere('attraction.category=:category')->setParameter('category', $category);
        }
        $qb->orderBy('attraction.createdAt','ASC');

        return $qb->getQuery();
    }
    public function attractionById($ids = null)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.id IN (:ids)')
            ->setParameter('ids', $ids);


        $qb->orderBy('attraction.createdAt','ASC');

        return $qb->getQuery()->getResult();
    }
    public function getAttractionByDay($day)
    {
        $qb = $this->createQueryBuilder('attraction')
            ->andWhere('attraction.days=:day')
            ->andWhere('attraction.deletedAt is null')
            ->setParameter('day',$day)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getAttractionArrayByDayPlans()
    {
        $days = [];
        $days[3][1] = $this->getAttractionByDay(1);
        $days[3][2] = $this->getAttractionByDay(2);
        $days[3][3] = $this->getAttractionByDay(3);
        $days[5][4] = $this->getAttractionByDay(4);
        $days[5][5] = $this->getAttractionByDay(5);
        $days[7][6] = $this->getAttractionByDay(6);
        $days[7][7] = $this->getAttractionByDay(7);

        return $days;
    }

    public function getDatatableData(Array $categoryIds){
        $qb = $this->createQueryBuilder('attraction')
            ->select('attraction.title')
            ->addSelect('attraction.id')
            ->addSelect('category.title as categoryTitle')
            ->addSelect('attraction.price')
            ->addSelect('attraction.review')
            ->addSelect('attraction.dontShowOnScreen')
            ->addSelect('attraction.deletedAt')
            ->addSelect('attraction.updateAt')
            ->addSelect('attraction.createdAt')
            ->leftJoin('attraction.category','category');

        foreach($categoryIds as $key => $val){
            $qb->orWhere('category.id = :key'.$key)
                ->setParameter('key'.$key, $val);

            if($val == Category::ATTRACTION_CATEGORY_BLOG){
                $qb->orWhere('attraction.blog is not null');
            }
        }
        $qb->andWhere('attraction.blog is null');
        $qb->orderBy('attraction.createdAt','DESC');

        $result = $qb->getQuery();

        return $result->getResult();
    }
}
