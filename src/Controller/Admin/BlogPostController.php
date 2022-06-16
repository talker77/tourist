<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blog/post")
 */
class BlogPostController extends AbstractController
{
    /**
     * @Route("/{blog}", name="admin_blog_post_index", methods={"GET"})
     * @Template()
     */
    public function index(Blog $blog)
    {
        $posts = $blog->getPosts();

        return array('posts'=>$posts,'blog'=>$blog);
    }

    /**
     * @Route("/{blog}/new", name="admin_blog_post_new", methods={"GET","POST"})
     * @Template()
     */
    public function new(Request $request,Blog $blog)
    {

        $breadcrumb[] = array(
            'isActive' => false, 'name' => 'Blog', 'link' => $this->generateUrl('admin_blog_post_index',array('blog'=>$blog))
        );

        $breadcrumb[] = array(
            'isActive' => true, 'name' => 'New', 'link' => '#'
        );


        $blogPost = new BlogPost();
        $blogPost->setBlog($blog);
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogPost);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_post_index',array('blog'=>$blog->getId()));
        }

        return array(
            'breadcrumb' => $breadcrumb,
            'blog' => $blog,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{post}", name="admin_blog_post_edit", methods={"GET","POST"})
     * @Template()
     */
    public function edit(Request $request,BlogPost $post)
    {

        $breadcrumb[] = array(
            'isActive' => false, 'name' => $post->getBlog()->getTitle(), 'link' => $this->generateUrl('admin_blog_post_index',array('blog'=>$post->getBlog()->getId()))
        );

        $breadcrumb[] = array(
            'isActive' => true, 'name' => $post->getTitle(), 'link' => '#'
        );

        $em = $this->getDoctrine()->getManager();

        if ($request->get('locale')) {
            $post->setTranslatableLocale($request->get('locale'));
            $em->refresh($post);
        }


        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_post_edit',array('post'=>$post->getId(),'locale'=>$request->get('locale')));
        }

        return $this->render('admin/blog_post/edit.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'post' => $post,
                'form' => $form->createView())
            );
    }

    /**
     * @Route("/save-feature-image/{post}", name="admin_post_save_feature_image")
     */
    public function saveFeatureImage(BlogPost $post, Request $request, UploadService $uploadService)
    {
        $filepath = $uploadService->imageUpload($request->files->get('featuredImage'));
        if ($filepath) {
            $post->setFeatureImage($filepath);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('admin_blog_post_edit', array('post' => $post->getId()));

    }

    /**
     * @Route("/clean-feature-image/{post}", name="admin_post_clean_feature_image")
     */
    public function cleanFeatureImage(BlogPost $post, Request $request)
    {
        $post->setFeatureImage(null);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_blog_post_edit', array('post' => $post->getId()));
    }

    /**
     * @Route("/remove-post/{post}", name="admin_post_remove")
     */
    public function removePost(BlogPost $post, Request $request)
    {
        $this->getDoctrine()->getManager()->remove($post);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_blog_index');
    }

    /**
     * @Route("/set-fav/{post}", name="admin_post_set_fav")
     */
    public function setFavorite(BlogPost $post, Request $request)
    {

        if($request->get('favorite') == 1)
        {
            $post->setFavoriteAt(new \DateTime());
        }else{
            $post->setFavoriteAt(null);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_blog_post_index', array('blog' => $post->getBlog()->getId()));
    }

    /**
     * @Route("/duplicate/{post}", name="admin_post_duplicate")
     */
    public function duplicate(BlogPost $post, Request $request)
    {

        $newPost = clone $post;


        $newPost->setSlug($post->getSlug()." 2");
        $newPost->setTitle($post->getTitle()." 2");
        $em = $this->getDoctrine()->getManager();
        $em->persist($newPost);
        $em->flush();

        return $this->redirectToRoute('admin_blog_post_index', array('blog' => $post->getBlog()->getId()));
    }
}
