<?php


namespace App\Controller\Admin;

use App\Entity\Attraction;
use App\Entity\AttractionFaqQuestion;
use App\Entity\Category;
use App\Entity\Review;
use App\Form\AttractionFaqQuestionType;
use App\Form\AttractionType;
use App\Repository\AttractionFaqQuestionRepository;
use App\Service\AttractionService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin/attraction")
 */
class AttractionController extends AbstractController
{


    /**
     * @Route("/", name="admin_attraction")
     * @Template("admin/attraction/index.html.twig")
     */
    public function index(Request $request)
    {
        return array();
    }

    /**
     * @Route("/add", name="admin_attraction_add")
     * @Template("admin/attraction/addAttraction.html.twig")
     */
    public function attractionAdd(Request $request, AttractionService $attractionService)
    {
        $attractionEntity = new Attraction();
        $form = $this->createForm(AttractionType::class, $attractionEntity);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){
                $attractionService->attractionSave($request, $attractionEntity);
                return $this->redirectToRoute('admin_attraction_edit',['attraction'=>$attractionEntity->getId()]);
            }else{
                $this->addFlash('error', 'Please check the form');
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit/{attraction}", name="admin_attraction_edit")
     * @Template("admin/attraction/editAttraction.html.twig")
     */
    public function attractionEdit(Request $request, AttractionService $attractionService, Attraction $attraction,AttractionFaqQuestionRepository $attractionFaqQuestionRepository)
    {
        $form = $this->createForm(AttractionType::class, $attraction);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){
                $attractionService->attractionSave($request, $attraction);
                return $this->redirectToRoute('admin_attraction_edit',['attraction'=>$attraction->getId()]);
            }else{
                $this->addFlash('error', 'Please check the form');
            }
        }

        $faqs = $attractionFaqQuestionRepository->findBy(array('deletedAt' =>null,'attraction'=>$attraction));

        return array(
            'title' =>'Edit Attraction',
            'form' => $form->createView(),
            'item' =>$attraction,
            'faqs'=> $faqs
        );
    }

    /**
     * @Route("/listajax", name="admin_attraction_list_ajax")
     *
     */
    public function attractionListAjax(Request $request)//AJAX
    {
        $em = $this->getDoctrine();
        $attractions = $em->getRepository(Attraction::class)->getDatatableData(
            [
                Category::ATTRACTION_CATEGORY_MUSEUM_TOUR,
                Category::ATTRACTION_CATEGORY_ISTANBUL,
                Category::ATTRACTION_CATEGORY_MUSEUM,
                Category::ATTRACTION_CATEGORY_DAY,
                Category::ATTRACTION_CATEGORY_TICKETS,
                Category::ATTRACTION_CATEGORY_ACTIVITIES,
                Category::ATTRACTION_CATEGORY_DISCOUNT,
                Category::ATTRACTION_CATEGORY_TRANSFERS
            ]);
        return new JsonResponse(['data'=>$attractions]);
    }

    /**
     * @Route("/changestatus/{attraction}", name="admin_attraction_change_status")
     *
     */
    public function changeAttractionStatus(Request $request, Attraction $attraction, AttractionService $attractionService)//AJAX
    {
        $status = $request->get('status');
        $response = $attractionService->attractionChangeStatus($attraction, $status);

        return new JsonResponse(['data'=>$response]);
    }

    /**
     * @Route("/changedelete/{attraction}", name="admin_attraction_change_delete", methods={"GET","POST"})
     *
     */
    public function changeAttractionDelete(Request $request, Attraction $attraction, AttractionService $attractionService)//AJAX
    {
        $status = $request->get('status');
        $response = $attractionService->attractionChangeDelete($attraction, $status);

        return new JsonResponse(['data'=>$response]);
    }

    /**
     * @Route("/changesortindex/{attraction}", name="admin_attraction_change_sortindex")
     *
     */
    public function changeAttractionSortIndex(Request $request, Attraction $attraction, AttractionService $attractionService)//AJAX
    {
        $sortIndex = $request->get('sortIndex');
        $response = $attractionService->attractionChangeSortIndex($attraction, $sortIndex);

        return new JsonResponse(['data'=>$response]);
    }

    /**
     * @Route("/add-faq-question/{attraction}", name="admin_attraction_faq_add")
     * @Template()
     */
    public function addQuestion(Request $request, Attraction $attraction)
    {
        $attractionQuestion = new AttractionFaqQuestion();
        $attractionQuestion->setAttraction($attraction);
        $attractionQuestion->setCreatedAt(new \DateTime());
        $form = $this->createForm(AttractionFaqQuestionType::class, $attractionQuestion);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($attractionQuestion);
                $entityManager->flush();

                return $this->redirectToRoute('admin_attraction_edit',array('attraction'=>$attraction->getId()));
            }else{
                $this->addFlash('error', 'Please check the form');
            }
        }

        return array(
            'form' => $form->createView(),
            'attractionQuestion' => $attractionQuestion
        );
    }

    /**
     * @Route("/edit-faq-question/{faqQuestion}", name="admin_attraction_faq_edit")
     * @Template()
     */
    public function editQuestion(Request $request, AttractionFaqQuestion $faqQuestion)
    {
        $form = $this->createForm(AttractionFaqQuestionType::class, $faqQuestion);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($faqQuestion);
                $entityManager->flush();

                return $this->redirectToRoute('admin_attraction_edit',array('attraction'=>$faqQuestion->getAttraction()->getId()));
            }else{
                $this->addFlash('error', 'Please check the form');
            }
        }

        return array(
            'form' => $form->createView(),
            'attractionQuestion' => $faqQuestion
        );
    }

}