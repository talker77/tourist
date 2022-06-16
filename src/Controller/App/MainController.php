<?php

namespace App\Controller\App;

use App\Entity\Attraction;
use App\Entity\BlogPost;
use App\Entity\ContactFormItem;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\FaqQuestion;
use App\Entity\FaqQuestionCategory;
use App\Entity\NewsLetter;
use App\Entity\PageData;
use App\Entity\Review;
use App\Entity\Category;
use App\Repository\AttractionRepository;
use App\Repository\BlogPostRepository;
use App\Repository\ReviewRepository;
use App\Service\BlogService;
use App\Service\DocumentService;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @Route("/es", name="homepage_es")
     * @Template()
     */
    public function index(Request $request, AttractionRepository $attractionRepository,DocumentService $documentService,NotificationService $notificationService,BlogPostRepository $blogPostRepository)
    {


        $em = $this->getDoctrineManager();
        $attractions = $attractionRepository->getHomeAttraction($ids = array(), $limit = 10);
        $review = $em->getRepository(Review::class)->getTotalRating();
        $reviewRepository = $em->getRepository(Review::class);
        $reviews = $reviewRepository->getTopReviews($limit=10);
        $topblogs = $attractionRepository->getBlogItems($limit=8);
        $lastBlogs = $em->getRepository(BlogPost::class)->findBy(array('blog' => 1,'isActive' => 1), array('publishedAt' => 'DESC'), 10);
        $istanbulVideos = $em->getRepository(BlogPost::class)->findBy(array('blog' => 7), array('createdAt' => 'DESC'), 100);
        $peopleVideos = $em->getRepository(BlogPost::class)->findBy(array('blog' => 8), array('createdAt' => 'DESC'), 100);

        $slide = date('s') % 6;

        $document = $this->getDoctrine()->getRepository(Document::class)->findOneBy(array('handle'=>"homepage"));
        $cmsLibrary = $documentService->getDocumentBySlug('library');
        $dataArray = array();
        foreach($document->getBlocks() as $block)
        {
            $fieldArray = array();
            $dataArray[$block->getPlaceHolder()] =  $this->getDoctrine()->getRepository(DocumentBlockData::class)->findBy(array('document'=>$document,'block'=>$block));;
        }
        $document->blockData = $dataArray;

        if($request->request->get('e-mail'))
        {
            $newsletter = new NewsLetter();
            $newsletter->setEmail($request->get('e-mail'));
            $newsletter->setCreatedAt(new \DateTime());
            $newsletter->setStatus(1);
            $this->getDoctrine()->getManager()->persist($newsletter);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success',"Thank for your subscribe");
        }

        return [
            'slideNumber' => $slide,
            'attractions' => $attractions,
            'attractionByDay' => $attractionRepository->getAttractionArrayByDayPlans(),
            'review' => $review,
            'lastBlogs' => $lastBlogs,
            'reviews' => $reviews,
            'topblogs' => $topblogs,
            'istanbulVideos' => $istanbulVideos,
            'peopleVideos' => $peopleVideos,
            'document' => $document,
            'cmsLibrary' => $cmsLibrary
        ];
    }


    /**
     * @Route("/istanbul-pass", name="price")
     * @Route("/prices", name="price")
     * @Template()
     */
    public function price(AttractionRepository $attractionRepository,DocumentService $documentService, Request $request)
    {
        $em = $this->getDoctrineManager();
        if($request->getRequestUri()=='/prices') return $this->redirect('/istanbul-pass', 301);
        $document = $documentService->getDocumentBySlug('prices');
        /**@var AttractionRepository $attractionRepository*/
        $attractions = $attractionRepository->findBy(['deletedAt'=>Null,'category'=>[Category::ATTRACTION_CATEGORY_ATTRACTION,Category::ATTRACTION_CATEGORY_MUSSEUM]],['sortingIndex'=>'ASC']);
        $attractionsByCategory = $attractionRepository->getAttractionsWithCategory();
        $review = $em->getRepository(Review::class)->getTotalRating();


        return [
            'page' => 'Groups',
            'attractions' => $attractions,
            'entity' => $attractionsByCategory,
            'reviewCount' => count($review),
            'review' => $review,
            'nobanner' => true,
            'document' => $document
        ];
    }





    /**
     * @Route("/reviews", name="testimonails")
     * @Template("app/main/pages/reviews.html.twig")
     */
    public function testimonails(Request $request, DocumentService $documentService,NotificationService $notificationService)
    {

        $em = $this->getDoctrineManager();

        $review = $em->getRepository(Review::class)->getTotalRating();
        $reviewRepository = $em->getRepository(Review::class);
        $reviews = $reviewRepository->getTopReviews($limit=5);
        $peopleVideos = $em->getRepository(BlogPost::class)->findBy(array('blog' => 8), array('createdAt' => 'DESC'), 25);

        $document = $documentService->getDocumentBySlug("reviews");

        if($request->get('message') && $request->get('fullname'))
        {
            $recaptcha = new \ReCaptcha\ReCaptcha($this->getParameter('google_recaptcha_secret_key'));
            $resp = $recaptcha->verify($request->get('g-recaptcha-response'));

            if(!$resp->isSuccess())
            {
                $this->addFlash('error',"Please check the reCaptcha");
                return $this->redirectToRoute('reviews',array('error'));
            }

            $fname = $request->request->get('fullname');
            $from = $request->request->get('from');
            $message = $request->request->get('message');
            $rate = $request->get('barrate');
            $orderId = $request->get('orderid');
            $active = 0;
            $created = date("Y-m-d H:i:s");
            if($rate>=1) $rate=5;
            // Used native sql cuz of p_review field name "from". backquote solved.
            $RAW_QUERY = 'INSERT INTO `p_review` (`name`, `from`,`rating`,`orderid`, `review`,`is_active`,`created_at`) VALUES ("'.$fname.'", "'.$from.'" ,"'.$rate.'","'.$orderId.'", "'.$message.'","'.$active.'","'.$created.'")';

            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();

            $this->addFlash('success',"Thank for your review");
            return $this->redirectToRoute('reviews',array('done'));
        }

        return [
            'route' => 'app/main/pages/reviews.html.twig',
            'document' => $document,
            'reviews' => $reviews,
            'review'  => $review,
            'peopleVideos' => $peopleVideos
        ];
    }
    /**
     * @Route("/reviews/ajax")
     */
    public function callReviews(Request $request)//AJAX
    {
        $em = $this->getDoctrineManager();

        $reviewRepository = $em->getRepository(Review::class);
        $reviews = $reviewRepository->getTopReviews($request->request->get('start'),$limit=$request->request->get('limit'));
        return new JsonResponse(['data'=>$reviews]);

    }
    /**
     * @Route("/frequently-asked-questions", name="faq")
     * @Template("app/main/pages/faq.html.twig")
     */
    public function faq(DocumentService $documentService)
    {
        $em = $this->getDoctrineManager();
        $mostPopularFaqs = $em->getRepository(FaqQuestion::class)->findBy(['category'=>6]);
        $document = $documentService->getDocumentBySlug('frequently-asked-questions');
        return [
            'route' => 'app/main/pages/faq.html.twig',
            'mostPopularFaqs' => $mostPopularFaqs,
            'document' => $document
        ];
    }

    /**
     * @Route("/contact", name="contact")
     * @Template("app/main/page.html.twig")
     */
    public function askUs(Request $request,NotificationService $notificationService,DocumentService $documentService)
    {
        $document = $documentService->getDocumentBySlug('contact');
        if($request->request->get('email'))
        {

            $recaptcha = new \ReCaptcha\ReCaptcha($this->getParameter('google_recaptcha_secret_key'));
            $resp = $recaptcha->verify($request->get('g-recaptcha-response'));

            if(!$resp->isSuccess())
            {
                $this->addFlash('error',"Please check the reCaptcha");
                return $this->redirectToRoute('contact',array('error'));
            }


            $contactform = new ContactFormItem();
            $contactform->setEmail($request->get('email'));
            $contactform->setName($request->get('name'));
            $contactform->setPhone($request->get('phone'));
            $contactform->setSubject($request->get('subject'));
            $contactform->setMessage($request->get('message'));
            $contactform->setCreatedAt(new \DateTime());


            $this->getDoctrine()->getManager()->persist($contactform);
            $this->getDoctrine()->getManager()->flush();

            $notificationService->sendVendorUserWelcomeMail(
                $contactform
            );

            $this->addFlash('success',"Thank for your message");

            return $this->redirectToRoute('contact',array('done'));


        }


        return [
            'route' => 'app/main/pages/ask_us.html.twig',
            'document' => $document
        ];
    }



    /**
     * @Route("/reviews", name="reviews")
     * @Template("app/main/page.html.twig")
     */
    public function reviews(Request $request, ReviewRepository $reviewRepository)
    {

        $em = $this->getDoctrineManager();
        $reviewRepository = $em->getRepository(Review::class);

        $totalRating = $reviewRepository->getTotalRating();
        $rating = $totalRating['totalRating'] / $totalRating['totalReviews'];
        $review = $em->getRepository(Review::class)->getTotalRating();


        if ($request->get('id'))
        {
            $id = $request->get('id');
            $reviews  = $reviewRepository->findOneBy(['id'=>$id]);
        }
        else {
            $reviews = $reviewRepository->findBy(array(),array('rating' => 'DESC'));
        }

        $reviewColors = [
            '#f44336',
            '#FFC107',
            '#FFC107',
            '#47b475',
            '#47b475'
        ];

        return [
            'route' => 'app/main/pages/reviews.html.twig',
            'reviews' => $reviews,
            'colors' => $reviewColors,
            'totalRating' => round($rating,2),
            'totalReviews' => $totalRating['totalReviews'],
            'reviewCount' => count($review),
            'review' => $review
        ];
    }



    private function getDoctrineManager()
    {
        return $this->getDoctrine()->getManager();
    }

}

