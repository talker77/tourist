<?php

namespace App\Controller\App;

use App\Entity\Attraction;
use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\FaqQuestionCategory;
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

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog_index")
     * @Template()
     */
    public function blog(BlogService $blogService,Request $request)
    {
        $blog = $blogService->getBlogBySLug("blog");
        switch ($blog->getId()){
            default:
            case 4:
            case 1: $view = 'app/blog/blog_main.html.twig'; break;
            case 3: $view = 'app/blog/blog_main_2.html.twig'; break;
        }
        return $this->render($view, array('slug'=>"blog",'blog' =>$blog));
    }

    /**
     * @Route("/b/{slug}", name="blog_main")
     * @Template()
     */
    public function blogMulti(BlogService $blogService,$slug,Request $request)
    {
        switch($slug){
            case"frequently-asked-questions": return $this->redirect('/blog', 301); break;
            case"weather-in-istanbul": return $this->redirect('/weather-in-istanbul', 301); break;
            case"media": return $this->redirect('/media', 301); break;
            case"special-offers": return $this->redirect('/special-offers', 301); break;
        }

        $blog = $blogService->getBlogBySLug($slug);
        switch ($blog->getId()){
            default:
            case 4:
            case 1: $view = 'app/blog/blog_main.html.twig'; break;
            case 3: $view = 'app/blog/blog_main_2.html.twig'; break;
        }
        return $this->render($view, array('slug'=>$slug,'blog' =>$blog));
    }

    /**
     * @Route("/search/{key}", name="blog_search")
     * @Template()
     */
    public function search(BlogService $blogService,$key)
    {
        $blog = $blogService->getBlogBySLug("blog");
        return [
            'route' => 'app/main/search.html.twig',
            'key' => strtolower($key),
            'blog' => $blog
        ];
    }


    private function getDoctrineManager()
    {
        return $this->getDoctrine()->getManager();
    }
}

