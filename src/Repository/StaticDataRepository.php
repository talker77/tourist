<?php

namespace App\Repository;

use App\Entity\FaqQuestion;
use App\Entity\FaqQuestionCategory;
use App\Entity\StaticData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StaticData|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaticData|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaticData[]    findAll()
 * @method StaticData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaticDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaticData::class);
    }

}
