<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="admin_blog_index", methods={"GET"})
     * @Template()
     */
    public function index(BlogRepository $blogRepository,Request $request)
    {
        $lang = $request->getLocale();
        $blogs = $blogRepository->findBy(array('deletedAt'=>null,'lang'=>$lang));

        return array('blogs'=>$blogs);
    }

    /**
     * @Route("/new", name="admin_blog_new", methods={"GET","POST"})
     * @Template()
     */
    public function new(Request $request)
    {

        $breadcrumb[] = array(
            'isActive' => false, 'name' => 'Blog', 'link' => $this->generateUrl('admin_blog_index')
        );

        $breadcrumb[] = array(
            'isActive' => true, 'name' => 'New', 'link' => '#'
        );


        $blog = new Blog();
        $blog->setLang("en");
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_index');
        }

        return array(
            'breadcrumb' => $breadcrumb,
            'blog' => $blog,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{blog}", name="admin_blog_edit", methods={"GET","POST"})
     * @Template()
     */
    public function edit(Request $request,Blog $blog)
    {

        $breadcrumb[] = array(
            'isActive' => false, 'name' => 'Blog', 'link' => $this->generateUrl('admin_blog_index')
        );

        $breadcrumb[] = array(
            'isActive' => true, 'name' => $blog->getTitle(), 'link' => '#'
        );

        $em = $this->getDoctrine()->getManager();

        if ($request->get('locale')) {

            $em->refresh($blog);
        }


        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_edit',array('blog'=>$blog->getId(),'locale'=>$request->get('locale')));
        }

        return $this->render('admin/blog/edit.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'blog' => $blog,
                'form' => $form->createView())
            );
    }

    /**
     * @Route("/save-feature-image/{blog}", name="blog_save_feature_image")
     */
    public function saveFeatureImage(Blog $blog, Request $request, UploadService $uploadService)
    {
        $filepath = $uploadService->upload($request->files->get('featuredImage'));
        if ($filepath) {
            $blog->setFeatureImage($filepath);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('admin_blog_edit', array('blog' => $blog->getId()));

    }

    /**
     * @Route("/clean-feature-image/{blog}", name="blog_clean_feature_image")
     */
    public function cleanFeatureImage(Blog $blog, Request $request)
    {
        $blog->setFeatureImage(null);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_blog_edit', array('blog' => $blog->getId()));
    }


}
