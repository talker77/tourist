<?php

namespace App\Controller\App;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\FaqQuestionCategory;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AttractionController extends AbstractController
{
    /**
     * @Route("/whats-included", name="attraction_index")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function index(Request $request,DocumentService $documentService)
    {
        $em = $this->getDoctrineManager();
        $category = $em->getRepository(Category::class)->findAll();
        $faqsCategories = $em->getRepository(FaqQuestionCategory::class)->findBy(['deletedAt'=>NULL]);
        $document = $documentService->getDocumentBySlug('whats-included');
        $attractions = [];
        if($request->get('sort')){
            $sortType = $request->get('sort');
            if($sortType=='attraction_name'){
                $attractions = $em->getRepository(Attraction::class)->findBy(array('dontShowOnScreen'=>NULL),array('title'=>'ASC'));
            }else if($sortType=='normal_gate_price'){
                    $attractions = $em->getRepository(Attraction::class)->findBy(array('dontShowOnScreen'=>NULL),array('price'=>'DESC'));
            }
            else if($sortType=='attraction_name'){
                $attractions = $em->getRepository(Attraction::class)->findBy(array('dontShowOnScreen'=>NULL),array('price'=>'DESC'));
            }
        }
        else{
            $attractions = $em->getRepository(Attraction::class)->findBy(array('dontShowOnScreen'=>NULL),array('sortingIndex'=>'ASC'));
        }


        return [
            'attractions' => $attractions,
            'categories' => $category,
            'faqsCategories' => $faqsCategories,
            'document' => $document
        ];
    }

    private function getDoctrineManager()
    {
        return $this->getDoctrine()->getManager();
    }

}