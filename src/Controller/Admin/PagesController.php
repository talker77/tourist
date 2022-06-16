<?php


namespace App\Controller\Admin;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\ContactFormItem;
use App\Entity\FaqQuestion;
use App\Entity\FaqQuestionCategory;
use App\Entity\PageData;
use App\Entity\Review;
use App\Form\AttractionType;
use App\Service\AttractionService;
use App\Service\FaqService;
use App\Service\PageDataService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin")
 */
class PagesController extends AbstractController
{


    /**
     * @Route("/terms", name="admin_terms")
     * @Template("admin/forms/terms.html.twig")
     */
    public function TermsEdit(Request $request)
    {
        $pageDataRepo = $this->getDoctrine()->getRepository(PageData::class);
        $terms = $pageDataRepo->getValue('terms');
            if(!empty($request->get('terms'))){
                $newTerms = $request->get('terms');
                $terms->setValue($newTerms);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success',"Terms Saved!");
                return $this->redirectToRoute('admin_terms');
            }
        return array(
            'terms'=>$terms->getValue()
        );
    }


    /**
     * @Route("/faq", name="admin_faq")
     * @Template("admin/forms/faq.html.twig")
     */
    public function faqEdit(Request $request, FaqService $faqService)
    {
        $em = $this->getDoctrine();
        if(!empty($request->get('faqCategoryName'))){
            $faqService->addQuestionCategory($request->get('faqCategoryName'));
        }
        if(!empty($request->get('faq'))){
            if(!empty($request->get('faq')['new'])){
                $faqService->newQuestion($request->get('faq')['new']['questions']);
            }else{
                $faqService->saveFaq($request);
            }
        }
        $faqsCategories = $em->getRepository(FaqQuestionCategory::class)->findBy(['deletedAt'=>NULL]);
        return array(
            'faqCategories'=>$faqsCategories
        );
    }

    /**
     * @Route("/faq/question/remove/{question}", name="admin_faq_remove_question")
     *
     */
    public function removeQuestion(Request $request, FaqQuestion $question)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $question->setDeletedAt(new \DateTime());
            $em->flush();
            return new JsonResponse(['message'=> "Question Deleted"], 200);
        }catch (Exception $exception){
            return new JsonResponse(['message'=> "Question couldn't delete"], 500);
        }
    }

    /**
     * @Route("/faq/question/remove-category/{category}", name="admin_faq_remove_category_question")
     *
     */
    public function removeQuestionCategory(Request $request, FaqQuestionCategory $category, FaqService $faqService)
    {
        try{
            $faqService->removeCategory($category);
            return new JsonResponse(['message'=> "Question Deleted"], 200);
        }catch (Exception $exception){
            return new JsonResponse(['message'=> "Question couldn't delete"], 500);
        }
    }

    /**
     * @Route("/pages/main-page", name="admin_pages_mainpage")
     * @Template("admin/pages/mainpage.html.twig")
     */
    public function mainPage(Request $request, PageDataService $pageDataService)
    {
        if($request->isMethod('post')){
            $pageDataService->updatePageData($request);
            $this->redirectToRoute('admin_pages_mainpage');
        }
        return [];
    }

    /**
     * @Route("/pages/plansave", name="admin_pages_plansave")
     * @Template("admin/pages/plansave.html.twig")
     */
    public function planSavePage(Request $request, PageDataService $pageDataService)
    {
        if($request->isMethod('post')){
            $pageDataService->updatePageData($request);
            $this->redirectToRoute('admin_pages_plansave');
        }
        return [];
    }

    /**
     * @Route("/pages/attraction", name="admin_pages_attraction")
     * @Template("admin/pages/attraction.html.twig")
     */
    public function attractionPage(Request $request, PageDataService $pageDataService)
    {
        if($request->isMethod('post')){
            $pageDataService->updatePageData($request);
            $this->redirectToRoute('admin_pages_attraction');
        }
        return [];
    }

    /**
     * @Route("/pages/prices", name="admin_pages_prices")
     * @Template("admin/pages/prices.html.twig")
     */
    public function pricesPage(Request $request, PageDataService $pageDataService)
    {
        if($request->isMethod('post')){
            $pageDataService->updatePageData($request);
            $this->redirectToRoute('admin_pages_prices');
        }
        return [];
    }

    /**
     * @Route("/pages/contact", name="admin_pages_contact")
     * @Template("admin/pages/contact.html.twig")
     */
    public function contactPage(Request $request, PageDataService $pageDataService)
    {
        $messages = $this->getDoctrine()->getRepository(ContactFormItem::class)->findBy([],['createdAt'=>'DESC']);
        return ['messages'=>$messages];
    }


    /**
     * @Route("/pages/contact/getmessage/{message}", name="admin_pages_contact_getmessage")
     *
     */
    public function getMessage(Request $request, ContactFormItem $message, PageDataService $pageDataService)
    {
        $em = $this->getDoctrine()->getManager();
        try{
            $message->setReadAt(new \DateTime());
            $em->persist($message);
            $em->flush();
            return new JsonResponse(['name'=>$message->getName(),'email'=>$message->getEmail(), 'date'=>(new \DateTime($message->getCreatedAt()))->format('d/m/Y'),'message'=>$message->getMessage()], 200);
        }catch (NoResultException $exception){
            return new JsonResponse(['message'=>$exception->getMessage()],500);
        }
    }

    /**
     * @Route("/pages/groups", name="admin_pages_groups")
     * @Template("admin/pages/groups.html.twig")
     */
    public function groupsPage(Request $request, PageDataService $pageDataService)
    {
        if($request->isMethod('post')){
            $pageDataService->updatePageData($request);
            $this->redirectToRoute('admin_pages_groups');
        }
        return [];
    }

//    /**
//     * @Route("/pages/contact", name="admin_pages_careers")
//     * @Template("admin/pages/careers.html.twig")
//     */
//    public function careersPage(Request $request, PageDataService $pageDataService)
//    {
//        $messages = $this->getDoctrine()->getRepository(ContactFormItem::class)->findBy([],['createdAt'=>'DESC']);
//        if($request->isMethod('post')){
//            $pageDataService->updatePageData($request);
//            $this->redirectToRoute('admin_pages_careers');
//        }
//        return ['messages'=>$messages];
//    }


}