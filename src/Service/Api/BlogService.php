<?php


namespace App\Service\Api;


use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use App\Repository\StaticDataRepository;

class BlogService
{


    /**
     * @var AttractionRepository
     */
    private $attractionRepository;

    public function __construct(AttractionRepository $attractionRepository)
    {
        $this->attractionRepository = $attractionRepository;
    }


    public function getList($limit =15)
    {
        $statics = array();
        $rows = $this->attractionRepository->getBlogItems($limit);
        foreach($rows as $static)
        {
          $statics[] = $this->decorate($static);
        }

        return $statics;

    }



    public function decorate(Attraction $attraction)
    {
        $images = array();
        foreach($attraction->getImages() as $image)
        {
            $images[] = $image->getSrc();
        }

        return array('title'=>$attraction->getTitle(),'description'=>$attraction->getDescription(),'id'=>$attraction->getId(),'images'=>$images);
    }

}