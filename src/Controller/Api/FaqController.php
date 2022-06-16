<?php

namespace App\Controller\Api;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Review;
use App\Repository\AttractionRepository;
use App\Repository\CategoryRepository;
use App\Service\Api\FaqService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/api/faq")
 */
class FaqController extends AbstractController
{
    /**
     * @Route("")
     * @Template()
     */
    public function index(Request $request,FaqService $faqService)
    {

        return $this->json($faqService->getList());
    }


}

