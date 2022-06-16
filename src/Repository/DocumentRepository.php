<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function findOneBySlug($slug)
    {
        $qb =  $this->createQueryBuilder('d')
            ->select('d,blocks,fields')
            ->leftJoin('d.blocks','blocks')
            ->leftJoin('blocks.fields','fields')
            ->andWhere('d.handle = :slug')->setParameter('slug',$slug,ParameterType::STRING);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
