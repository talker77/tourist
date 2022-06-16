<?php


namespace App\Service;


use App\Entity\PageData;
use App\Utility\StringUtility;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class PageDataService
{
    private $container;
    private $entityManager;
    private $flashBag;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface, FlashBagInterface $flashBag)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->flashBag = $flashBag;
    }

    public function updatePageData(Request $request){
        try{
            $pageDataEntity = $this->entityManager->getRepository(PageData::class)->find($request->get('id'));
            !empty($request->get('title')) ? $pageDataEntity->setTitle($request->get('title')): NULL;
            $pageDataEntity->setValue($request->get('value'));
            $pageDataEntity->setUpdatedAt(new \DateTime());
            $this->entityManager->flush();
            $this->flashBag->add('success','Changes are Saved');
        }catch (ORMException $exception){
            $this->flashBag->add('error','Error');
        }
    }

}