<?php

namespace App\Controller\App;


use App\Entity\Attraction;
use App\Entity\BlogPost;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", defaults={"_format"="xml"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine();
        $attractions =  $em->getRepository(Attraction::class)->findBy(array('deletedAt'=>null), array('createdAt'=>'ASC'));
        $blogs = $em->getRepository(BlogPost::class)->findBy(array('blog' => 1,'isActive' => 1,'deletedAt'=>null), array('createdAt'=>'ASC'));
        $staticPages = array(
            "how_it_works",
            "plan_and_save",
            "about_us",
            "upgrade_pass",
            "tourist_attractions_in_istanbul",
            "weather_in_istanbul",
            "cookies",
            "site_map",
            "return_policy",
            "become_a_reseller",
            "become_affiliate_partner",
            "become_business_partner",
            "careers",
            "istanbul_public_transportation_card",
            "istanbul_privite_tour_guide",
            "terms_conditions",
            "privacy_policy",
            "reseller",
            "our_partners",
            "why_choose_istanbul_pass",
            "skip_ticket_line",
            "special_offers",
            "about_app",
            "istanbul_tourist_pass",
            "istanbul_museum_pass",
            "istanbul_guided_museum_pass",
            "istanbul_guided_museum_tours",
            "timetable",
            "istanbul_guidebook",
            "istanbul_map",
            "covid_pcr_test_in_istanbul",
            "things_todo_in_istanbul",
            "groups",
            "browse_attractions_map",
        );
        return $this->render('app/sitemap.xml.twig', array('attractions'=>$attractions,"blogs"=>$blogs, 'staticPages' =>$staticPages));
    }
}
