<?php

namespace App\Controller\Api;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Review;
use App\Repository\AttractionRepository;
use App\Repository\CategoryRepository;
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
 * @Route("/api/attraction")
 */
class AttractionController extends AbstractController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function list(Request $request, AttractionRepository $attractionRepository)
    {
        $attractions = $attractionRepository->getActives();
        return new JsonResponse($attractions);
    }

    /**
     * @Route("/recommend/{attraction}")
     * @Template()
     */
    public function recommend(Request $request,Attraction $attraction, AttractionRepository $attractionRepository)
    {

        $attractions = $attractionRepository->getApiRecommandation($attraction,$request->get('limit',4));

        return new JsonResponse($attractions);
    }

    /**
     * @Route("/category/{category}")
     * @Template()
     */
    public function attractionCategory(Request $request,Category $category, AttractionRepository $attractionRepository)
    {
        $attractions = $attractionRepository->attractionByCategory($category->getId())->getResult();
        return new JsonResponse($attractions);
    }

    /**
     * @Route("/popular")
     * @Template()
     */
    public function popular( AttractionRepository $attractionRepository)
    {
        $att=  $attractionRepository->getHomeAttraction(array(),10);
        return new JsonResponse($att);
    }


    /**
     * @Route("/nearby")
     * @Template()
     */
    public function nearby(Request $request,AttractionRepository $attractionRepository)
    {

        $attractions = $attractionRepository->getActives();
        $items = array();
        foreach($attractions as $attraction)
        {
            $data = array();
            $data['id'] =$attraction->getId();

            $image = null;
            if($attraction->getImages()) {
                $image = $attraction->getImages()->first();
            }
            $data['image'] = $image;
            $data['lat'] =$attraction->getLat();
            $data['lng'] =$attraction->getLng();
            $data['title'] =$attraction->getTitle();

            $items[] = $data;
        }

        return new JsonResponse($items);
    }

    /**
     * @Route("/search/{keyword}")
     * @Template()
     */
    public function search(Request $request,string  $keyword,AttractionRepository  $attractionRepository)
    {
        $attractions = array();
        $attractions['keyword'] = $keyword;
        $attractions['items'] = $attractionRepository->search($keyword);

        return new JsonResponse($attractions);
    }

    /**
     * @Route("/{attraction}")
     * @Template()
     */
    public function attractionDetail(Request $request,Attraction $attraction)
    {
        return new JsonResponse($attraction);
    }


}

