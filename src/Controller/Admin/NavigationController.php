<?php

namespace App\Controller\Admin;

use App\Entity\Navigation;
use App\Entity\NavigationItem;
use App\Form\NavigationType;
use App\Service\NavigationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/navigation")
 */
class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="navigation_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {

        $navigations = $this->getDoctrine()
            ->getRepository(Navigation::class)
            ->findAll();

        return $this->render('admin/navigation/index.html.twig', [
            'navigations' => $navigations,
        ]);
    }


    /**
     * @Route("/new", name="navigation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $navigation = new Navigation();
        $navigation->setLang($request->getLocale());
        $form = $this->createForm(NavigationType::class, $navigation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($navigation);
            $entityManager->flush();

            return $this->redirectToRoute('navigation_index');
        }

        return $this->render('admin/navigation/new.html.twig', [
            'navigation' => $navigation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="navigation_show", methods={"GET"})
     */
    public function show(Navigation $navigation): Response
    {
        return $this->render('admin/navigation/show.html.twig', [
            'navigation' => $navigation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="navigation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Navigation $navigation, NavigationService $navigationService): Response
    {

        $breadcrumb[] =  array(
            'isActive' => false, 'name' => 'Navigations','link'=> $this->generateUrl('navigation_index')
        );

        $breadcrumb[] =  array(
            'isActive' => false, 'name' => $navigation->getTitle(),'link'=> '#'
        );


        $form = $this->createForm(NavigationType::class, $navigation);
        $form->handleRequest($request);

        $categoryTree = $navigationService->getTreeForJsTree($navigation,$request->getLocale());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('navigation_index', [
                'id' => $navigation->getId(),
            ]);
        }

        return $this->render('admin/navigation/edit.html.twig', [
            'navigation' => $navigation,
            'form' => $form->createView(),
            'categoryTree' => $categoryTree,
            'breadcrumb' => $breadcrumb
        ]);
    }





    /**
     * @Route("/{id}", name="navigation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Navigation $navigation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$navigation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($navigation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('navigation_index');
    }




}
