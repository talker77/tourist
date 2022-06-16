<?php


namespace App\Service;


use App\Entity\Attraction;
use App\Entity\Category;
use App\Utility\StringUtility;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AttractionService
{
    private $container;
    private $entityManager;
    private $flashBag;
    private $attractionImageService;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface, FlashBagInterface $flashBag, AttractionImageService $attractionImageService)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->flashBag = $flashBag;
        $this->attractionImageService = $attractionImageService;
    }


    public function attractionSave($request, Attraction $attractionEntity){
        $em = $this->entityManager;
            if($attractionEntity->getCategory() && $attractionEntity->getCategory()->getId() == Category::ATTRACTION_CATEGORY_BLOG){
                $attractionEntity->setBlog(1);
            }
            if(!empty($request->files->get('thumbnail'))){
                $thumbnail = $request->files->get('thumbnail');
                $url = $this->attractionImageService->attractionThumbnailUpload($thumbnail, $attractionEntity);
                $attractionEntity->setThumbnail($url);
            }
            if(!empty($request->files->get('videoCover'))){
                $videoCover = $request->files->get('videoCover');
                $url = $this->attractionImageService->attractionVideoCoverUpload($videoCover, $attractionEntity);
                $attractionEntity->setVideoCover($url);
            }
            if(empty($attractionEntity->getCreatedAt())){
                $attractionEntity->setDontShowOnScreen(1);
                $attractionEntity->setCreatedAt(new \DateTime());
            }else{
                $attractionEntity->setUpdateAt(new \DateTime());
            }
            if(empty($attractionEntity->getSlug())){
                $attractionEntity->setSlug(StringUtility::urlSlugify(explode('(',$attractionEntity->getTitle())[0]));
            }
        $em->persist($attractionEntity);
        $em->flush();
        $this->flashBag->add('success', "Saved");
        return $attractionEntity;
    }

    public function attractionChangeStatus(Attraction $attraction, $status){
        $em = $this->entityManager;
        try{
            $attraction = $em->getRepository(Attraction::class)->find($attraction);
            if($status=="true"){
                $attraction->setDontShowOnScreen(null);
            }else{
                $attraction->setDontShowOnScreen(1);
            }
            $em->flush();
            return new JsonResponse(['status'=>true],200);
        }catch (Exception $e){
            return new JsonResponse(['status'=>false],500);
        }
    }

    public function attractionChangeDelete(Attraction $attraction, $status){
        $em = $this->entityManager;
        try{
            $attraction = $em->getRepository(Attraction::class)->find($attraction);
            if($status=="true"){
                $attraction->setDeletedAt(null);
            }else{
                $attraction->setDeletedAt(new \DateTime());
            }
            $em->flush();
            return new JsonResponse(['status'=>true],200);
        }catch (Exception $e){
            return new JsonResponse(['status'=>false],500);
        }
    }

    public function attractionChangeSortIndex(Attraction $attraction, $sortIndex){
        $em = $this->entityManager;
        try{
            $attraction = $em->getRepository(Attraction::class)->find($attraction);
            $attraction->setSortingIndex($sortIndex);
            $em->flush();
            return new JsonResponse(['status'=>true],200);
        }catch (Exception $e){
            return new JsonResponse(['status'=>false],500);
        }
    }


    public function blogSave(Request $request, Attraction $blog){
        $category = $this->entityManager->getRepository(Category::class)->find(Category::ATTRACTION_CATEGORY_BLOG);
        $blog->setCategory($category);
        return $this->attractionSave($request, $blog);
     }

}