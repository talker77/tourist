<?php

namespace App\Controller\App;

use App\Entity\Attraction;
use App\Entity\AttractionFaqQuestion;
use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\FaqQuestionCategory;
use App\Entity\NewsLetter;
use App\Entity\Review;
use App\Repository\AttractionFaqQuestionRepository;
use App\Repository\AttractionRepository;
use App\Repository\BlogPostRepository;
use App\Repository\FaqQuestionCategoryRepository;
use App\Repository\LanguageRepository;
use App\Service\BlogService;
use App\Service\DocumentService;
use App\Service\NavigationService;
use Gedmo\Loggable\Document\Repository\LogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ZDetailController extends AbstractController
{


    /**
     * @Route("/save-newslettter", name="save_newsletter")
     * @Template()
     */
    public function saveNewsletter(Request $request)
    {

        /*$newsletter = new NewsLetter();
        $newsletter->setEmail($request->get('e-mail'));
        $newsletter->setCreatedAt(new \DateTime());
        $newsletter->setStatus(1);
        $this->getDoctrine()->getManager()->persist($newsletter);
        $this->getDoctrine()->getManager()->flush();*/
        //6c9fc685df9f5d5b768cb6814ebaf9b9-us16

        $apikey = "6c9fc685df9f5d5b768cb6814ebaf9b9-us16";  // found in Account -> extra
        $list_id = "82b5f42e4d."; // found in Audience -> audience id
        $email = $request->get('e-mail');
        $data = array('apikey' => $apikey, 'email_address' => $email, 'status' => 'subscribed',);


        $ch = curl_init('https://us20.api.mailchimp.com/3.0/lists/'.$list_id.'/members/');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: apikey '.$apikey,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($ch);

        $status = "";
        $msg = "";
        $myArray = json_decode($response, true);
        foreach($myArray as $key => $value){
            if( $key == "status" ){
                $status=$value;
            }
            else if ($key == "title"){
                $msg=$value;
            }
        }
        if( $status == "subscribed" ){
            $this->addFlash('success', "Thank for your subscribe");
        } else {
            $this->addFlash('error', "Sorry can not subscribe email");
        }

        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @Route("/{slug}", name="app_general_index")
     * @Route("/{slug}", name="attraction_detail")
     * @Route("/{slug}", name="blog_detail")
     * @Route("/how-it-works", name="how_it_works")
     * @Route("/plan-and-save", name="plan_and_save")
     * @Route("/about-us", name="about_us")
     * @Route("/upgrade-pass", name="upgrade_pass")
     * @Route("/tourist-attractions-in-istanbul", name="tourist_attractions_in_istanbul")
     * @Route("/weather-in-istanbul", name="weather_in_istanbul")
     * @Route("/cookies", name="cookies")
     * @Route("/site-map", name="site_map")
     * @Route("/return-policy", name="return_policy")
     * @Route("/reseller", name="become_a_reseller")
     * @Route("/become-affiliate-partner", name="become_affiliate_partner")
     * @Route("/our-partners", name="become_business_partner")
     * @Route("/careers", name="careers")
     * @Route("/istanbul-public-transportation-card", name="istanbul_public_transportation_card")
     * @Route("/istanbul-privite-tour-guide", name="istanbul_privite_tour_guide")
     * @Route("/terms-and-conditions", name="terms_conditions")
     * @Route("/privacy-policy", name="privacy_policy")
     * @Route("/reseller", name="reseller")
     * @Route("/our-partners", name="our_partners")
     * @Route("/why-choose-istanbul-pass", name="why_choose_istanbul_pass")
     * @Route("/skip-ticket-line", name="skip_ticket_line")
     * @Route("/special-offers", name="special_offers")
     * @Route("/about-app", name="about_app")
     * @Route("/istanbul-tourist-pass", name="istanbul_tourist_pass")
     * @Route("/istanbul-museum-pass", name="istanbul_museum_pass")
     * @Route("/istanbul-guided-museum-pass", name="istanbul_guided_museum_pass")
     * @Route("/istanbul-guided-museum-tours", name="istanbul_guided_museum_tours")
     * @Route("/guided-tours-timetable", name="timetable")
     * @Route("/free-digital-istanbul-guidebook", name="istanbul_guidebook")
     * @Route("/free-digital-istanbul-map", name="istanbul_map")
     * @Route("/covid-pcr-test-in-istanbul", name="covid_pcr_test_in_istanbul")
     * @Route("/things-todo-in-istanbul", name="things_todo_in_istanbul")
     * @Route("/groups", name="groups")
     * @Route("/browse-attractions-map", name="browse_attractions_map")
     */
    public function index($slug, DocumentService $documentService, AttractionRepository $attractionRepository,BlogService $blogService,BlogPostRepository $blogPostRepository, Request $request)
    {

        $em = $this->getDoctrineManager();
        $rd = $this->redirectUrl($slug); // redirect old urls 301
        if(isset($rd)) return $this->redirect($rd, 301);

        $blogPost = $blogPostRepository->findOneBySlug($slug);
        if($blogPost) {
            $attractionDetailSlider = $em->getRepository(BlogPost::class)->findBy(array('blog' => 10), array('createdAt' => 'DESC'), 100);
            $lastBlogs = $em->getRepository(BlogPost::class)->findBy(array('blog' => 1,'isActive' => 1), array('createdAt' => 'DESC'), 10);
            return $this->render('app/blog/blog_detail.html.twig', ['slug' => "media", 'blog' => $blogPost->getBlog(), 'lastestblogs' => $lastBlogs, 'post' => $blogPost,'attractionDetailSliders' => $attractionDetailSlider]);
        }



        $attraction = $attractionRepository->findOneBy(array('slug' => $slug));
        if ($attraction) {

            $reviewRepository = $em->getRepository(Review::class);
            $reviews = $reviewRepository->getTopReviews($limit = 10);
            $topAttractions = $attractionRepository->getHomeAttraction($ids = array(), $limit = 10);
            $attractionDetailSlider = $em->getRepository(BlogPost::class)->findBy(array('blog' => 10), array('createdAt' => 'DESC'), 100);
            $document = $documentService->getDocumentBySlug('attraction-detail');
            $faqs = $this->getDoctrine()->getRepository(AttractionFaqQuestion::class)->findBy(array('deletedAt' => null, 'attraction' => $attraction));

            return $this->render('app/attraction/attraction.html.twig', array('attraction' => $attraction, 'reviews' => $reviews, 'document' => $document, 'faqs' => $faqs, 'topAttractions' => $topAttractions,'attractionDetailSliders' => $attractionDetailSlider));
        }

        $document = $documentService->getDocumentBySlug($slug);
        if ($document) {
            $faqsCategories = $this->getDoctrine()->getRepository(FaqQuestionCategory::class)->findBy(['deletedAt' => NULL]);
            $template = "app/main";
            $topblogs = $attractionRepository->getBlogItems($limit = 8);
            $thingsBlogs = $em->getRepository(BlogPost::class)->findBy(array('blog' => 6), array('createdAt' => 'DESC'), 100);
            $mediaBlogs = $em->getRepository(BlogPost::class)->findBy(array('blog' => 2), array('createdAt' => 'DESC'), 100);
            $weathers = $em->getRepository(BlogPost::class)->findBy(array('blog' => 3), array('createdAt' => 'DESC'), 100);
            $specialOffers = $blogService->getBlogBySLug("special-offers");
            $touristattractions = $em->getRepository(BlogPost::class)->findBy(array('blog' => 11), array('createdAt' => 'ASC'), 100);
            $istanbulGuidedMuseums = $em->getRepository(Attraction::class)->attractionById(array('4','2','6','5','19','16','20'));
            $attractions = $attractionRepository->getHomeAttraction($ids = array(), $limit = 10);
            $cmsLibrary = $documentService->getDocumentBySlug('library');
            return $this->render($template . $document->getTemplate(),
                array('document' => $document,
                    'cmsLibrary' => $cmsLibrary,
                    'slug' => $slug,
                    'faqsCategories' => $faqsCategories,
                    'attractionByDay' => $attractionRepository->getAttractionArrayByDayPlans(),
                    'thingsBlogs'=>$thingsBlogs,
                    'mediaBlogs'=>$mediaBlogs,
                    'weathers'=>$weathers,
                    'topblogs' => $topblogs,
                    'attractions' => $attractions,
                    'istanbulGuidedMuseums' => $istanbulGuidedMuseums,
                    'specialOffers' => $specialOffers,
                    'touristattractions' => $touristattractions
                )
            );
        }

        throw new NotFoundHttpException("PAGE NOT FOUND");
    }
    protected function redirectUrl(string $slug)
    {
        $redirects = array (
            'css'=>'/',
            ','=>'/',
            'itp-banner-rc.html'=>'/',
            'turkish-and-islamic-arts-museum-guided-tour'=>'turkish-and-islamic-arts-museum',
            'princes-islands-boat-trip-round-trip'=>'princes-islands-boat-trip',
            'what-included'=>'whats-included',
            'istanbul-privite-tour-guide'=>'istanbul-private-tour-guide',
            'free-digital-istanbul-map'=>'free-digital-istanbul-maps',
            'jungle-park-istanbul-isfanbul'=>'jungle-park',
            'hagia-sophia-museum%22'=>'hagia-sophia-museum',
            'dungeon-istanbul-isfanbul'=>'dungeon',
            'bosphorus-dinner-cruise'=>'bosphorus-dinner-cruise-with-turkish-shows',
            'dialogue-in-the-dark-silence-istanbul'=>'dialogue-in-the-dark',
            'jungle-park-istanbul-isfanbu'=>'jungle-park',
            'dialogue-in-the-silence-istanbul'=>'dialogue-in-the-silence',
            'a-brief-history-of-the-ottoman-empire'=>'history-of-the-ottoman-empire',
            'safari-istanbul-isfanbul'=>'safari',
            'fox'=>'media',
            'legoland-istanbul'=>'legoland-discovery-centre-istanbul',
            'dolmabahce-palace'=>'dolmabahce-palace-museum',
            'besiktas-stadium-tour'=>'besiktas-jk-stadium-guided-tour',
            'hagia-irene-museum-guided-tour'=>'hagia-irene-museum',
            'hagia-sophia-museum&quot;'=>'hagia-sophia-museum',
            'istanbul-is-inviting-you'=>'istanbul-weather-inviting-you',
            'istanbul-weather-is-inviting-you'=>'istanbul-weather-inviting-you',
            'b/frequently-asked-questions'=>'b/weather-in-istanbul',
            'search'=>'blog',
            'covid-safe'=>'covid-pcr-test-in-istanbul',
            'prices' => 'istanbul-pass',
            'price' => 'istanbul-pass',
            'things-to-do-in-istanbul' => 'things-todo-in-istanbul',
        );
        foreach ($redirects as $oldurl=>$newurl){

            if ($slug==$oldurl){
                return $newurl;
            }
        }
    }

    private function getDoctrineManager()
    {
        return $this->getDoctrine()->getManager();
    }

}

