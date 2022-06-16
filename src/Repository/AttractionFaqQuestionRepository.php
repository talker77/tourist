<?php

namespace App\Repository;

use App\Entity\AttractionFaqQuestion;
use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AttractionFaqQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttractionFaqQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttractionFaqQuestion[]    findAll()
 * @method AttractionFaqQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttractionFaqQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttractionFaqQuestion::class);
    }


}
