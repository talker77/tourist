<?php

namespace App\Controller\App;

use App\Entity\Category;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\FaqQuestionCategory;
use App\Entity\FaqQuestion;
use App\Repository\AttractionRepository;
use App\Repository\BlogPostRepository;
use App\Repository\LanguageRepository;
use App\Service\BlogService;
use App\Service\DocumentService;
use App\Service\NavigationService;
use Gedmo\Loggable\Document\Repository\LogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/partial")
 */
class PartialController extends AbstractController
{

    /**
     * @Route("/faq", name="app_partial_faq")
     * @Template("app/main/snip/faq_snip.html.twig")
     */
    public function faq()
    {
        $faqsCategories = $this->getDoctrine()->getRepository(FaqQuestionCategory::class)->findBy(['deletedAt'=>NULL]);
        $rUrl = str_replace('/','',$_SERVER['REQUEST_URI']);

        return [
            'faqsCategories'=> $faqsCategories,
            'rUrl' => $rUrl
        ];
    }



}

