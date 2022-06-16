<?php

namespace App\Controller\Api;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Review;
use App\Repository\AttractionRepository;
use App\Repository\CategoryRepository;
use App\Service\Api\BlogService;
use App\Service\Api\StaticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/api/homepage")
 */
class HomePageController extends AbstractController
{

    /**
     * @Route("")
     * @Template()
     */
    public function homePage(Request $request,AttractionRepository $attractionRepository,CategoryRepository $categoryRepository,StaticService $service,BlogService $blogService)
    {

        $attractionJsonArray = array();
        $attractionJsonArray['categories'] = $categoryRepository->getActives();
        $attractionJsonArray['topAttractions'] =  $attractionRepository->getHomeAttraction(array(),10);
        $attractionJsonArray['recommendations'] = $attractionRepository->getActives();
        $attractionJsonArray['statics'] = $service->getList();
        $attractionJsonArray['blogs'] = $blogService->getList();

        return new JsonResponse($attractionJsonArray);
    }

}

